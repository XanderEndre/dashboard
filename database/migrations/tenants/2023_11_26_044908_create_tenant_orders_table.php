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
        Schema::create('tenant_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantCustomer::class, 'customer_id')
                ->constrained('tenant_customers')
                ->comment('Foreign key referencing the customer');
            $table->bigInteger('po_number');
            // status
        
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
