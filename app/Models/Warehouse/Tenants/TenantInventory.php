<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantInventory extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'vendor_item_name',
        'description',
        'cost',
        'item_type',
        'item_dirty_level',
        'item_trk_option',
        'item_valuation_method',
        'item_unit_of_measure',
        'item_purchase_tax_option',
        'is_active',
        'vendor_id',
        'sub_item_id'
    ];


    public static array $itemType = ['STOCK', 'DISCONTINUED', 'SERVICES', 'LABOR'] ?? null;
    public static array $itemDirtyLevel = ['N/A', 'VERY CLEAN', 'CLEAN', 'MODERATE', 'DIRTY'] ?? null;
    public static array $itemTrkOption = ['NONE', 'DATE', 'LOT'] ?? null;
    public static array $itemValuationMethod = ['FIFO Perpetual', 'LIFO Perpetual', 'Average Perpetual', 'FIFO Periodic', 'LIFO Periodic'] ?? null;
    public static array $itemUnitOfMeasure = ['OUNCES', 'GRAMS', 'EACH', 'TIME'] ?? null;
    public static array $itemPurchaseTaxOptions = ['TAXABLE', 'NONTAXABLE', 'VENDOR'] ?? null;

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(TenantVendor::class, 'vendor_id');
    }

    public function substituteItem() : BelongsTo
    {
        return $this->belongsTo(TenantInventory::class, 'sub_item_id');
    }

    public function formatted()
    {
        $lines = [
            $this->name,
            "(" . ($this->is_active ? "enabled" : "disabled") . ")"
        ];

        // Filter out any empty lines
        $lines = array_filter($lines);

        return implode("\n", $lines);
    }
}

