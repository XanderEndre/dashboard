<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantAddressable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'address_id'
  
    ];

    public function addressable() : MorphToMany
    {
        return $this->morphToMany(TenantVendor::class, 'addressable');
    }


    public function formatted()
    {
        $lines = [
            $this->address,
            $this->address_two,
            $this->city . ', ' . $this->state . ' ' . $this->zipcode,
            'United States' // Only add this if you have addresses outside the US or it's relevant to display the country
        ];

        // Filter out any empty lines
        $lines = array_filter($lines);

        return implode("\n", $lines);
    }

}
