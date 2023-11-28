<?php

namespace App\Jobs;

use App\Models\Warehouse\Tenants\TenantAuditLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WriteAuditLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $action;
    protected $description;
    protected $userId;
    protected $tenantId;


    public function __construct($action, $description, $userId, $tenantId)
    {
        $this->description = $description;
        $this->action = $action;
        $this->userId = $userId;
        $this->tenantId = $tenantId;
    }


    /**
     * Execute the job.
     */
    public function handle() : void
    {
        // Log the start of the job
        Log::info("WriteAuditLogJob // started for tenantId: {$this->tenantId}");
        try {

            $schemaNameQuoted = '"' . $this->tenantId . '"';



            // Set the connection to the tenant's schema
            Config::set('database.connections.tenant.search_path', $schemaNameQuoted);

            // Refresh the connection with new settings
            DB::purge('tenant');
            // Config::set('database.connections.tenant.schema', 'pgsql');
            DB::reconnect('tenant');

            // Now perform the insertion or other operations
            // Ensure that all database operations in this job use the 'tenant' connection
            $audit = TenantAuditLog::on('tenant')->create([
                'action' => $this->action,
                'description' => $this->description,
                'user_id' => $this->userId,
            ]);

            // dd($audit);
            Log::info('WriteAuditLogJob // Audit log created: ' . json_encode($audit));

        } catch (\Exception $e) {
            // Handle the exception
            Log::error('WriteAuditLogJob // Error in WriteAuditLogJob: ' . $e->getMessage());
        }
    }
}
