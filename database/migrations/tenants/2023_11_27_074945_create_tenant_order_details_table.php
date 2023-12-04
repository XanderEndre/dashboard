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
                ->constrained('tenant_orders');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\Recipe\TenantRecipes::class, 'recipe_id')
                ->constrained('tenant_recipes');
            $table->bigInteger('quantity');
            $table->decimal('total_cost');
            // $table->decimal('line_total', 10, 2)->storedAs('tenant_inventories.item_id * quantity');
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
