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
        Schema::create('tenant_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\Order\TenantOrders::class, 'order_id')
                ->constrained('tenant_orders')
                ->comment('Foreign key referencing the customer');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantInventory::class, 'item_id')
                ->constrained('tenant_inventories')
                ->comment('Foreign key referencing the customer');
            $table->bigInteger('quantity');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_order_details');
    }
};
