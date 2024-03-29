<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantAddressType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'address_type',
        'address',
        'address_two',
        'city',
        'state',
        'country',
        'zipcode',
        'phone_number',
        'email'
    ];

    public static array $addressType = ['Delivery Address', 'Billing Address'] ?? null;


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
