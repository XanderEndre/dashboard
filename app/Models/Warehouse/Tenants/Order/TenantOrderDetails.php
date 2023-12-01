<?php

namespace App\Models\Warehouse\Tenants\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantOrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'quantity',
        'item_id'
    ];
}


