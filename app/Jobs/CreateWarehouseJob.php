<?php

namespace App\Jobs;

use App\Events\CreateWarehouseEvent;
use App\Models\User;
use App\Models\Warehouse\Warehouse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class CreateWarehouseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenantData;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct($tenantData)
    {
        $this->tenantData = $tenantData;
        $this->user = auth()->user();

    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        Log::info("CreateWarehouseJob // started for the user id {$this->user->id}");
        DB::beginTransaction();

        try {

            // Assume 'tenantData' contains necessary information like 'name', 'schema', etc.
            $warehouseName = $this->tenantData['name'];
            // Generate a UUID for the schema name
            $schemaName = Str::uuid()->toString();

            // Create the warehouse record
            $warehouse = Warehouse::create([
                'name' => $warehouseName,
                'schema_name' => $schemaName, // Use the generated UUID
                'subdomain' => null,
                'primary_email' => 'null',
                'warehouse_owner_id' => $this->user->id
            ]);

            // Set the connection to the tenant's schema
            $schemaNameQuoted = '"' . $schemaName . '"';
            DB::connection('tenant')->statement('CREATE SCHEMA IF NOT EXISTS ' . $schemaNameQuoted);

            Config::set('database.connections.tenant.search_path', $schemaNameQuoted);

            // Refresh the connection with new settings
            DB::purge('tenant');
            // Config::set('database.connections.tenant.schema', $schemaName);
            DB::reconnect('tenant');


            // Run the migrations for the tenant's database
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenants',
            ]);

            dispatch(new AddWarehouseUser($this->user, $warehouse, null));
            dispatch(new WriteAuditLogJob('created', 'Created Warehouse \'' . $warehouse->name . '\'', $this->user->id, $warehouse->schema_name));

            // Maybe dispatch an event after completion
            // event(new CreateWarehouseEvent($this->tenantData));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CreateWarehouseJob // Error in CreateWarehouseJob: ' . $e->getMessage());
        }
    }
}
