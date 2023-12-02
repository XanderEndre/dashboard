<?php

namespace App\Models\Warehouse\Tenants\Order;

use App\Models\Warehouse\Tenants\TenantCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantOrders extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'po_number',
        'customer_id'
    ];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(TenantCustomer::class, 'customer_id');
    }

//CO200
    // public static array $orderProgress = ['', 'IN PROGRESS', ] ?? null;
    // Delivery Address (Differ from the customer?)
    // RECEIVED, IN PROGRESS, BUILD
    // REVIEW, RUN ROOM, BUILD, SHRINK, BOX, DELIVERY, COMPLETED
    // HIGHLIGHT SUBSTITUTION (flag? inventory, stock?)
    // box types (which box we're going to put it in)

}
