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
        Schema::create('tenant_recipe_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\Recipe\TenantRecipes::class, 'recipe_id')
                ->constrained('tenant_recipes')
                ->comment('Foreign key referencing the customer');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantInventory::class, 'item_id')
                ->constrained('tenant_inventories')
                ->comment('Foreign key referencing the customer');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\Recipe\TenantRecipeItemPackagings::class, 'packaging_id')
                ->constrained('tenant_recipe_item_packagings')
                ->comment('Foreign key referencing the customer');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_recipe_items');
    }
};
