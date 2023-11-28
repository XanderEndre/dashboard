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
        Schema::create('tenant_inventories', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(\App\Models\Warehouse\Warehouse::class, 'warehouse_id')
            //     ->constrained('warehouses')
            //     ->onDelete('cascade') // Ensures that deleting a warehouse deletes related addresses
            //     ->comment('Foreign key referencing the warehouse');

            $table->string('name')
                ->comment('The Short Name/Description for this item');

            $table->string('description')
                ->comment('Description of the item');


            // $table->foreignIdFor(\App\Models\Warehouse\Inventory\InventoryCategory::class, 'inventory_category_id')
            //     ->constrained('inventory_categories')
            //     ->comment('Link to general description for the item to allow substitutions, include both a main category and a sub-category');

            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantVendor::class, 'vendor_id')
                ->nullable()
                ->constrained('tenant_vendors')
                ->comment('Link to general description for the item to allow substitutions, include both a main category and a sub-category');

            $table->foreignIdFor(\App\Models\Warehouse\Tenants\TenantInventory::class, 'sub_item_id')
                ->nullable()
                ->constrained('tenant_inventories')
                ->comment('Link to general description for the item to allow substitutions, include both a main category and a sub-category');

            $table->bigInteger('cost')
                ->comment('Current cost will be updated automatically by received purchases according to the Valuation Method selected. ');
            $table->string('custom_po_item_name')
                ->nullable()
                ->comment('Name from the Customer PO');

            $table->string('vendor_item_name')
                ->nullable()
                ->comment('Name from the Vendor');

            // $table->enum('item_type', InventoryItem::$itemType)
            //     ->comment('Integer for this type of item: 1. Stock Item 2. Discontinued 3. Services 4. Labor');

            // $table->enum('item_dirty_level', InventoryItem::$itemDirtyLevel)
            //     ->comment('The level of dirtiness.');

            // $table->enum('item_trk_option', InventoryItem::$itemTrkOption)
            //     ->comment('The level of dirtiness.');

            // $table->enum('item_valuation_method', InventoryItem::$itemValuationMethod)
            //     ->comment('The level of dirtiness.');

            // $table->enum('item_unit_of_measure', InventoryItem::$itemUnitOfMeasure)
            //     ->comment('The level of dirtiness.');

            // $table->enum('item_purchase_tax_option', InventoryItem::$itemPurchaseTaxOptions)
            //     ->comment('Indicator that this item is taxable, nontaxable or based on vendors.');

            $table->text('ingredient_label')
                ->nullable()
                ->comment('Detailed Ingredient Label');

            $table->boolean('is_active');

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
