<?php

use App\Models\Warehouse\Tenants\TenantInventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('tenant_inventories', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('The Short Name/Description for this item');

            $table->string('description')
                ->comment('Description of the item');

            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantVendor::class, 'vendor_id')
                ->nullable()
                ->constrained('tenant_vendors')
                ->comment('Foreign key linking to the vendor of this item');

            $table->foreignIdFor(TenantInventory::class, 'sub_item_id')
                ->nullable()
                ->constrained('tenant_inventories')
                ->comment('Optional reference to a related sub-item');

            $table->decimal('package_size', 8, 2); // Precision and scale added
            $table->decimal('case_cost', 10, 2); // Precision and scale added
            $table->decimal('shipping_cost', 10, 2); // Precision and scale added

            $table->decimal('total_cost', 10, 2)->storedAs('((case_cost / package_size) / 16) + shipping_cost');

            // $table->decimal('case_cost', 10, 2); // Precision and scale added
            // $table->decimal('total_cost', 10, 2);


            $table->string('custom_po_item_name')
                ->nullable()
                ->comment('Name from the Customer PO');

            $table->string('vendor_item_name')
                ->nullable()
                ->comment('Name from the Vendor');

            $table->enum('item_type', TenantInventory::$itemType)
                ->comment('Integer for this type of item: 1. Stock Item 2. Discontinued 3. Services 4. Labor');

            $table->enum('item_dirty_level', TenantInventory::$itemDirtyLevel)
                ->comment('The level of dirtiness.');

            $table->enum('item_trk_option', TenantInventory::$itemTrkOption)
                ->comment('The level of dirtiness.');

            $table->enum('item_valuation_method', TenantInventory::$itemValuationMethod)
                ->comment('The level of dirtiness.');

            $table->enum('item_unit_of_measure', TenantInventory::$itemUnitOfMeasure)
                ->comment('The level of dirtiness.');

            $table->enum('item_purchase_tax_option', TenantInventory::$itemPurchaseTaxOptions)
                ->comment('Indicator that this item is taxable, nontaxable or based on vendors.');

            $table->text('ingredient_label')
                ->nullable()
                ->comment('Detailed Ingredient Label, if applicable');


            $table->boolean('is_active')
                ->default(true) // Added default value
                ->comment('Indicates if the item is currently active');

            $table->string('reference_image')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tenant_inventories');
    }
};
