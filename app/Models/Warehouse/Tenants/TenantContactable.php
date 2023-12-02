<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantContactable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'extension',
        'is_active'
    ];

    public function vendors() : MorphToMany
    {
        return $this->morphToMany(TenantVendor::class, 'contactable');
    }

    public function customers() : MorphToMany
    {
        return $this->morphToMany(TenantCustomer::class, 'contactable');
    }

}
