<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('warehouse_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')
                ->onDelete('set null')
                ->constrained('users');

            $table->foreignIdFor(\App\Models\Warehouse\Warehouse::class, 'warehouse_id')
                ->constrained('warehouses')
                ->onDelete('cascade')
                ->comment('Foreign key referencing the warehouse');

            $table->unique(['user_id', 'warehouse_id'])
                ->onDelete('cascade');

            $table->foreignIdFor(\App\Models\Warehouse\WarehouseRoles::class, 'role_id')
                ->nullable()
                ->constrained('warehouse_roles');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('warehouse_users');
    }
};
