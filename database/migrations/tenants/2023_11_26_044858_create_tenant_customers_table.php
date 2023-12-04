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
        Schema::create('tenant_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('payment_terms');
            // $table->decimal('multiplier', 10, 2);
            $table->string('primary_email')->nullable();
            $table->text('notes')->nullable();
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantCustomer::class, 'parent_customer_id')
                ->nullable()
                ->constrained('tenant_customers')
                ->onDelete('set null')
                ->comment('Foreign key referencing the parent warehouse');
            $table->boolean('is_active')->comment('Active or inactive status of the customer');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_customers');
    }
};
