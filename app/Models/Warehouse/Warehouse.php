<?php

namespace App\Models\Warehouse;

use App\Models\User;
use App\Models\Warehouse\Users\WarehouseUserInvitations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'pgsql';


    protected $fillable = [
        'name',
        'subdomain',
        'schema_name',
        'primary_email',
        'warehouse_owner_id'
    ];

    // We need to define that the warehouse belongs to one and only one user
    public function warehouseOwner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'warehouse_owner_id');
    }

    public function warehouseUsers() : HasMany
    {
        return $this->hasMany(WarehouseUsers::class);
    }


    public function invitations() : HasMany
    {
        return $this->hasMany(WarehouseUserInvitations::class);
    }
}
