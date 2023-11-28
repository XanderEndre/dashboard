<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class MigrateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashtrac:migrate-tenant {tenant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for a specific tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch the name of the tenant
        $tenantSchemaName = $this->argument('tenant');


        // Create the warehouse through a job
        \App\Jobs\CreateWarehouseJob::dispatch($tenantSchemaName);
    }
}
