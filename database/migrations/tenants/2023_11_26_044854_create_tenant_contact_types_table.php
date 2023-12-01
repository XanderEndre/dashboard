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
        Schema::create('tenant_contact_types', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255);
            $table->string('phone_number', 20);
            $table->string('extension', 10)->nullable(); // Extension can be optional
            $table->boolean('is_active')->comment('Active or inactive status of the vendor');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_contact_types');
    }
};
