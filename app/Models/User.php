<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\WarehouseUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active_schema',
        'theme_color'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'active_schema'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Notate the warehouses that the user will own.
    public function warehousesOwned() : HasMany
    {
        return $this->hasMany(Warehouse::class, 'warehouse_owner_id');
    }

    // Notate that a user can/may belong to many warehouses
    public function warehouses() : BelongsToMany
    {
        //return $this->belongsToMany(Warehouse::class, 'warehouse_users', 'user_id', 'warehouse_id');
        return $this->belongsToMany(Warehouse::class, 'warehouse_users'); // not sure what to put here yet...
    }

    // Notate the warehouses the user is an employee/apart of.
    public function warehouseEmployeeOf() : HasMany
    {
        return $this->hasMany(WarehouseUsers::class, 'user_id');
    }

    // Notate their active warehouse
    public function activeWarehouse() : BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'active_schema');
    }

    
    public function receivedInvitations()
    {
        return $this->hasMany(WarehouseUserInvitations::class, 'email', 'email');
    }

}
