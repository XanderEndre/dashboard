<?php

namespace App\Models\Warehouse\Tenants\Recipe;

use App\Models\Warehouse\Tenants\Order\TenantOrderDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRecipes extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = "tenant";
    protected $table = 'tenant_recipes';

    protected $fillable = [
        'name',
        'box_id',
        'customer_id',
        'total_cost'
    ];


    public function boxPackaging() : BelongsTo
    {
        return $this->belongsTo(TenantRecipeBoxPackaging::class, 'box_id');
    }

    public function recipeItems() : HasMany
    {
        return $this->hasMany(TenantRecipeItems::class, 'recipe_id');
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(TenantOrderDetails::class, 'recipe_id');
    }
}
