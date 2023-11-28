<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantService
{
    /**
     * Set the connection for a specific tenant.
     *
     * @param string $schemaName The tenant's schema name.
     */
    public function setConnection(string $schemaName)
    {
        $schemaNameQuoted = '"' . $schemaName . '"';
        Config::set('database.connections.tenant.search_path', $schemaNameQuoted);

        DB::purge('tenant');
        Config::set('database.connections.tenant.schema', 'pgsql');
        DB::reconnect('tenant');
    }
}
