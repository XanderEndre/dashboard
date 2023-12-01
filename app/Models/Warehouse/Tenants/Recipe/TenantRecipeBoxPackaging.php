<?php

namespace App\Models\Warehouse\Tenants\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRecipeBoxPackaging extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'quantity'
    ];
}