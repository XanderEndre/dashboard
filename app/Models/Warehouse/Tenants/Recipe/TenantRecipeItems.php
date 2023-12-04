<?php

namespace App\Models\Warehouse\Tenants\Recipe;

use App\Models\Warehouse\Tenants\TenantInventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRecipeItems extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recipe_id',
        'ounces',
        'item_id',
        'packaging_id',
        'total_cost'
    ];

    public function recipe() : BelongsTo
    {
        return $this->belongsTo(TenantRecipes::class, 'recipe_id');
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(TenantInventory::class, 'item_id');
    }

    public function packaging() : BelongsTo
    {
        return $this->belongsTo(TenantRecipeItemPackagings::class, 'packaging_id');
    }

}
