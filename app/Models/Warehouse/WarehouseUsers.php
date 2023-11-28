<?php

namespace App\Models\Warehouse;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseUsers extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'pgsql';


    protected $fillable = [
        'user_id',
        'warehouse_id',
        'role_id',
        'is_active'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse() : BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(WarehouseRoles::class);
    }
}
