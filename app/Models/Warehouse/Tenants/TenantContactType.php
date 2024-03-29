<?php

namespace App\Models\Warehouse\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantContactType extends Model
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

    public function formatted()
    {
        $lines = [
            $this->first_name,
            $this->last_name,
            '(' . $this->email . ')'
        ];

        // Filter out any empty lines
        $lines = array_filter($lines);

        return implode("\n", $lines);
    }
}
