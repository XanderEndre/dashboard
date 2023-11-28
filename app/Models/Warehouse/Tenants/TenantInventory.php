<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantInventory extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'vendor_item_name',
        'description',
        'cost',
        // 'item_type',
        // 'item_dirty_level',
        // 'item_trk_option',
        // 'item_valuation_method',
        // 'item_unit_of_measure',
        // 'item_purchase_tax_option',
        // 'warehouse_id',
        'is_active',
        'vendor_id',
        'sub_item_id'
    ];


    public function vendor() : BelongsTo
    {
        return $this->belongsTo(TenantVendor::class, 'vendor_id');
    }

    public function substituteItem() : BelongsTo
    {
        return $this->belongsTo(TenantInventory::class, 'sub_item_id');
    }
}

