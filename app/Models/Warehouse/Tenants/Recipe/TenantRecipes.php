<?php

namespace App\Models\Warehouse\Tenants\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRecipes extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = "tenant";
    protected $table = 'tenant_recipes';

    protected $fillable = [
        'name',
        'box_id',
        'customer_id'
    ];
}
