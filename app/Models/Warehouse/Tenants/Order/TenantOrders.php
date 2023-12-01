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
}
