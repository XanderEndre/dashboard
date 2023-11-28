<?php

namespace App\Models\Warehouse\Users;

use App\Models\User;
use App\Models\Warehouse\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseUserInvitations extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['warehouse_id', 'email', 'inviter_id', 'invitation_token', 'expires_at', 'status'];

    public static array $status = ['pending', 'accepted', 'declined', 'expired'] ?? null;


    public function warehouse() : BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function inviter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }
}
