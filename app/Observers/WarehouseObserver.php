<?php

namespace App\Observers;

use App\Jobs\WriteAuditLogJob;
use App\Models\Warehouse;

class WarehouseObserver
{
    /**
     * Handle the Warehouse "created" event.
     */
    public function created(Warehouse $warehouse) : void
    {
        WriteAuditLogJob::dispatch('created', 'Created warehouse ' . $warehouse->name . ' at ' . $warehouse->created_at, $warehouse->schema_name);
    }

    /**
     * Handle the Warehouse "updated" event.
     */
    public function updated(Warehouse $warehouse) : void
    {
        WriteAuditLogJob::dispatch('updated', 'Updated warehouse ' . $warehouse->name . ' at ' . $warehouse->created_at, $warehouse->schema_name);
    }

    /**
     * Handle the Warehouse "deleted" event.
     */
    public function deleted(Warehouse $warehouse) : void
    {
        //
    }

    /**
     * Handle the Warehouse "restored" event.
     */
    public function restored(Warehouse $warehouse) : void
    {
        //
    }

    /**
     * Handle the Warehouse "force deleted" event.
     */
    public function forceDeleted(Warehouse $warehouse) : void
    {
        //
    }
}
