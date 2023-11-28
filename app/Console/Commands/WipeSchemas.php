<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WipeSchemas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:wipe-schemas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wipe all tenant schemas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch a list of all tenant schemas
        $schemas = DB::select('SELECT schema_name FROM information_schema.schemata');

        foreach ($schemas as $schema) {
            $schemaName = $schema->schema_name; // Access the schema_name property

            // Skip system schemas if necessary
            if (in_array($schemaName, ['information_schema', 'pg_catalog', 'public'])) {
                continue;
            }

            // Drop schema logic
            DB::statement("DROP SCHEMA IF EXISTS \"$schemaName\" CASCADE");
            $this->info("Dropped schema: $schemaName");
        }

        $this->info('All tenant schemas have been wiped!');
    }
}
