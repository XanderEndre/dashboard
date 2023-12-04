<?php

use App\Models\Warehouse\Tenants\Order\TenantOrders;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('tenant_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantCustomer::class, 'customer_id')
                ->constrained('tenant_customers')
                ->comment('Foreign key referencing the customer');
            $table->bigInteger('po_number');
            $table->enum('order_state', TenantOrders::$orderState);
            $table->date('expected_delivery_date');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantAddressType::class, 'address_id')
                ->nullable()
                ->constrained('tenant_address_types')
                ->onDelete('set null');
            $table->decimal('total_cost');
            $table->foreignIdFor(\App\Models\User::class, 'created_by')
                ->nullable()
                ->constrained('public.users')
                ->onDelete('set null');
            $table->foreignIdFor(\App\Models\User::class, 'updated_by')
                ->nullable()
                ->constrained('public.users')
                ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_orders');
    }
};
