<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'tenant';
    protected $table = 'tenant_customers';


    protected $fillable = [
        'name',
        'payment_terms',
        'primary_email',
        'notes',
        'parent_customer_id',
        'is_active'
    ];

    public function parentCustomer() : BelongsTo
    {
        return $this->belongsTo(TenantCustomer::class, 'parent_customer_id');
    }

    public function childrenCustomers() : HasMany
    {
        return $this->hasMany(TenantCustomer::class, 'parent_customer_id');
    }
}