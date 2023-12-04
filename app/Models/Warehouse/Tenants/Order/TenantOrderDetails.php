<?php

namespace App\Models\Warehouse\Tenants\Order;

use App\Models\Warehouse\Tenants\Recipe\TenantRecipes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantOrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'quantity',
        'recipe_id',
        'total_cost'
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(TenantOrders::class, 'order_id');
    }

    // TenantOrderDetails model
    public function recipes() : BelongsTo
    {
        return $this->belongsTo(TenantRecipes::class, 'recipe_id');
    }


}


