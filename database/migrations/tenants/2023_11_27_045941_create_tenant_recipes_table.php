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
        Schema::create('tenant_recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\Recipe\TenantRecipeBoxPackaging::class, 'box_id')
                ->constrained('tenant_recipe_box_packagings')
                ->comment('Foreign key referencing the type of box used');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantCustomer::class, 'customer_id')
                ->nullable()
                ->constrained('tenant_customers')
                ->comment('Foreign key referencing the customer');
            $table->decimal('total_cost', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_recipes');
    }
};