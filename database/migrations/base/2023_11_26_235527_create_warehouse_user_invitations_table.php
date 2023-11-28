<?php

use App\Models\Warehouse\Users\WarehouseUserInvitations;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('warehouse_user_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignIdFor(\App\Models\Warehouse\Warehouse::class, 'warehouse_id')
                ->constrained('warehouses')
                ->onDelete('cascade'); // Ensures that deleting a warehouse deletes related addresses
            $table->foreignIdFor(\App\Models\User::class, 'inviter_id')
                ->constrained('users');
            $table->string('invitation_token');
            $table->dateTime('expires_at');
            $table->enum('status', WarehouseUserInvitations::$status);

            $table->unique(['email', 'warehouse_id']); // This is the composite unique index
            // this makes sure there can only ever be one email and warehouse_id

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('warehouse_user_invitations');
    }
};
