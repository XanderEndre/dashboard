<?php

namespace App\Models\Warehouse;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseRoles extends Model
{
    use HasFactory, SoftDeletes;

    const OWNER = 'owner';
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const EMPLOYEE = 'employee';

    public static $roles = [
        self::OWNER,
        self::ADMIN,
        self::MANAGER,
        self::EMPLOYEE,
    ];

    public static $applicableRoles = [
        self::ADMIN,
        self::MANAGER,
        self::EMPLOYEE,
    ];

    public function warehouseRoles() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'warehouse_users', 'role_id', 'user_id');
        // return $this->belongsToMany(WarehouseUsers::class);
    }
}
