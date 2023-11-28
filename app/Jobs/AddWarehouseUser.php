<?php

namespace App\Jobs;

use App\Models\Warehouse\WarehouseUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddWarehouseUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $user;
    protected $warehouse;
    protected $roleId;

    public function __construct($user, $warehouse, $roleId)
    {
        $this->user = $user;
        $this->warehouse = $warehouse;
        $this->roleId = $roleId;
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        Log::info("AddWarehouseUser //  started for user: {$this->user->id} for warehouse {$this->warehouse}");
        try {

            // Set the connection to the tenant's schema
            $schemaNameQuoted = '"' . $this->warehouse->schema_name . '"';
            Config::set('database.connections.tenant.search_path', $schemaNameQuoted);

            // Refresh the connection with new settings
            DB::purge('tenant');
            Config::set('database.connections.tenant.schema', $schemaNameQuoted);
            DB::reconnect('tenant');


            WarehouseUsers::create([
                'user_id' => $this->user->id,
                'warehouse_id' => $this->warehouse->id,
                'role_id' => null, // You need to determine how to set this
                'is_active' => true,
            ]);

            // Set the user's active schema to the new warehouse's schema
            $this->user->active_schema = $this->warehouse->id;
            $this->user->save();

            WriteAuditLogJob::dispatch('created', 'Added user \'' . $this->user->name . '\' to the warehouse \'' . $this->warehouse->name . '\'', $this->user->id, $this->warehouse->schema_name);

        } catch (\Exception $e) {
            // Handle the exception
            Log::error('AddWarehouseUser // Error in AddWarehouseUser: ' . $e->getMessage());
            // Optionally, you might want to rethrow the exception or handle it differently
        }
    }
}
