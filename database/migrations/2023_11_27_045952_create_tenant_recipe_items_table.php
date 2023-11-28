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
            $table->string('name');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantRecipes::class, 'recipe_id')
                ->nullable()
                ->constrained('tenant_recipes')
                ->onDelete('set null')
                ->comment('Foreign key referencing the parent warehouse');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantInventory::class, 'recipe_item_id')
                ->nullable()
                ->constrained('tenant_inventories')
                ->onDelete('set null')
                ->comment('Foreign key referencing the parent warehouse');
            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantRecipePackaging::class, 'packaging_id')
                ->nullable()
                ->constrained('tenant_packagings')
                ->onDelete('set null')
                ->comment('Foreign key referencing the parent warehouse');

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
