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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Warehouse\Warehouse::class, 'active_schema')
                ->nullable()
                ->constrained('warehouses')
                ->onDelete('set null')
                ->comment('Foreign key referencing the warehouse');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_schema']);
            $table->dropColumn('active_schema');
        });
    }
};
