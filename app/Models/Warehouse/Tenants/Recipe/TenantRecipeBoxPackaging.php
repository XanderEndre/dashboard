<?php

namespace App\Models\Warehouse\Tenants\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRecipeBoxPackaging extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'max_item_quantity',
        'box_cost',
        'packing_cost',
        'shrink',
        'labor',
        'total_cost'
    ];

    public function recipe() : BelongsTo
    {
        return $this->belongsTo(TenantRecipes::class, 'recipe_id');
    }
}
