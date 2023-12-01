<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantVendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'tenant';


    protected $fillable = [
        'name',
        'short_name',
        'phone_number',
        'payment_terms',
        'account_number',
        'is_active'
    ];

    public function addresses() : MorphToMany
    {
        return $this->morphToMany(TenantAddressType::class, 'addressable', 'tenant_addressables', 'addressable_id', 'address_id');
    }

    public function contacts() : MorphToMany
    {
        return $this->morphToMany(TenantContactType::class, 'contactable', 'tenant_contactables', 'contactable_id', 'contact_id');
    }
}
