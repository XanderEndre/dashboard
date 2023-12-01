<?php

use App\Models\Warehouse\Tenants\TenantContactType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('tenant_contactables', function (Blueprint $table) {
            $table->id();
            $table->morphs('contactable');
            $table->foreignIdFor(TenantContactType::class, 'contact_id')
                ->constrained('tenant_contact_types')
                ->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // $table->unique(['addressable_id', ''])
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_contactables');
    }
};
