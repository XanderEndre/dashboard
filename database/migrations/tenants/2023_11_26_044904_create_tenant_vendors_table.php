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
        Schema::create('tenant_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full name of the vendor');
            $table->string('short_name')->comment('Short or abbreviated name of the vendor');
            $table->string('phone_number', 15)->comment('Contact phone number of the vendor');
            $table->string('payment_terms')->comment('Payment terms agreed with the vendor');
            $table->string('account_number', 20)->comment('Vendor account number for transactions');

            $table->boolean('is_active')->comment('Active or inactive status of the vendor');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_vendors');
    }
};
