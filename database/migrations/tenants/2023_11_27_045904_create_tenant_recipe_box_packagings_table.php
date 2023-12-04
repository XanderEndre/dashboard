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
        Schema::create('tenant_recipe_box_packagings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('max_item_quantity');
            $table->decimal('box_cost', 10, 2);
            $table->decimal('packing_cost', 10, 2);
            $table->decimal('shrink', 10, 2);
            $table->decimal('labor', 10, 2);
            $table->decimal('total_cost', 10, 2)->storedAs('(box_cost + packing_cost) + shrink + labor + 0.10');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_recipe_box_packagings');
    }
};
