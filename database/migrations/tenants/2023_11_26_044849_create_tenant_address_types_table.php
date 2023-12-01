<?php

use App\Models\Warehouse\Tenants\TenantAddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('tenant_address_types', function (Blueprint $table) {
            $table->id();
            $table->enum('address_type', TenantAddressType::$addressType)->nullable()->comment('Type of address');
            $table->string('address')->comment('Primary address line');
            $table->string('address_two')->nullable()->comment('Secondary address line (optional)');
            $table->string('city')->comment('City of the address');
            $table->string('state', 50)->comment('State or province of the address');
            $table->string('zipcode', 10)->comment('Zip or postal code');
            $table->string('country', 50)->comment('Country of the address');
            $table->string('phone_number', 50)->nullable()->comment('Country of the address');
            $table->string('email', 50)->nullable()->comment('Country of the address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_address_types');
    }
};
