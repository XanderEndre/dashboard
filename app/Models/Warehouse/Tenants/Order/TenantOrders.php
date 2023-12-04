<?php

namespace App\Models\Warehouse\Tenants\Order;

use App\Models\Warehouse\Tenants\Recipe\TenantRecipeItems;
use App\Models\Warehouse\Tenants\TenantCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantOrders extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'po_number',
        'customer_id',
        'order_state',
        'expected_delivery_date',
        'total_cost',
        'created_by',
        'updated_by'
    ];

    public static array $orderState = ['Review', 'Run Room', 'Build', 'Shrink', 'Package', 'Delivery', 'Completed'] ?? null;


    public function customer() : BelongsTo
    {
        return $this->belongsTo(TenantCustomer::class, 'customer_id');
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(TenantOrderDetails::class, 'order_id');
    }


    //CO200
    // public static array $orderProgress = ['', 'IN PROGRESS', ] ?? null;
    // Delivery Address (Differ from the customer?)
    // RECEIVED, IN PROGRESS, BUILD
    // REVIEW, RUN ROOM, BUILD, SHRINK, BOX, DELIVERY, COMPLETED
    // HIGHLIGHT SUBSTITUTION (flag? inventory, stock?)
    // box types (which box we're going to put it in)

}
