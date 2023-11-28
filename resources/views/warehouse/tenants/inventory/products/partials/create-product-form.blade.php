<section x-data="{
    items: [],
    selectedItemId: '',
    itemQty: '',
    itemOptions: [],
    init() {
        // Retrieve the itemOptions from PHP and convert it to an array if needed
        this.itemOptions = Object.entries(@js($itemOptions)).map(([id, name]) => ({ id, name }));
        console.log('itemOptions initialized:', this.itemOptions);
    },
    addItems() {
        // Log the current state for debugging
        console.log('Adding Items with:', {
            selectedItemId: this.selectedItemId,
            itemQty: this.itemQty,
            itemOptions: this.itemOptions,
        });

        // Find the selected item
        let selectedItem = this.itemOptions.find(item => item.id == this.selectedItemId);

        // Check for the selected item and a valid quantity
        if (selectedItem && this.itemQty && this.itemQty > 0) {
            this.items.push({
                id: selectedItem.id,
                name: selectedItem.name,
                quantity: this.itemQty
            });

            // Reset the selectedItemId and itemQty
            this.selectedItemId = '';
            this.itemQty = '';
        } else {
            console.error('Selected item not found or itemQty is missing or invalid');
        }
    },
    removeItem(index) {
        // Remove item at the specified index
        this.items.splice(index, 1);
    }
}">
    <form method="post" action="{{ route('warehouse.inventory.products.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create a Product'" :description="'Enter the details of this product'" />
            <x-cards.body>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <x-forms.input-label for="product_name" :value="__('Product Name')" required />
                        <x-forms.text-input id="product_name" name="product_name" type="text" :value="old('product_name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('product_name')" />
                    </div>
                    <div class="col-span-1">
                        <x-forms.input-label for="selected_product_type" :value="__('Product Type')" />
                        <x-forms.select name="selected_product_type" :options="$productTypes" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('selected_product_type')" />
                    </div>
                    <div class="col-span-2">
                        <x-forms.input-label for="is_active" :value="__('Item Enabled?')" required />
                        <select id="is_active" name="is_active"
                            class='mt-1 group w-full text-left flex justify-between items-center gap-2 border bg-white px-3 py-2 leading-6 rounded-lg border-gray-200 focus:outline-none focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-primary-500'>

                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>

                        </select>
                        <x-forms.input-error :messages="$errors->get('is_active')" class="mt-2" />
                    </div>
                </div>
            </x-cards.body>
        </x-cards.card>


        <div>
            @if (count($itemOptions) > 0)
                <!-- Only show if items exist -->
                <x-cards.card>
                    <x-cards.header :title="'Select Items'" :description="'Select the items for this product'" />
                    <x-cards.body>
                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-center mb-5">
                            <div class="col-span-3">
                                <x-forms.input-label for="selected_item_id" :value="__('Select Items')" />
                                <select name="selected_item_id" x-model="selectedItemId"
                                    class="mt-1 group w-full text-left flex justify-between items-center gap-2 border bg-white px-3 py-2 leading-6 rounded-lg border-gray-200 focus:outline-none focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-primary-500">
                                    <option value="" disabled>Select an item</option>
                                    <template x-for="(option, index) in itemOptions" :key="index">
                                        <option :value="option.id" x-text="option.name"></option>
                                    </template>
                                </select>
                                {{--                                 
                                <x-forms.select name="selected_item_id" x-model="selectedItemId" :options="$itemOptions"
                                    class="mt-1" :useOptionsAsValue="false" /> --}}
                            </div>
                            <div class="col-span-1">
                                <x-forms.input-label for="item_qty" :value="__('Item Quantity')" required />
                                <x-forms.text-input id="item_qty" x-model="itemQty" type="text"
                                    class="block w-full mt-1" required />
                                <x-forms.input-error class="mt-2" :messages="$errors->get('item_qty')" />
                            </div>
                            <div class="col-span-1">
                                <x-buttons.primary-button class="w-full mt-6 py-2" @click="addItems()"
                                    type="button">Add
                                    Item</x-buttons.primary-button>
                            </div>
                        </div>

                        <x-tables.table :headers="['Order', 'Item Name', 'Item QTY', 'Actions']">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <x-tables.td class="py-1" x-text="index + 1"></x-tables.td>
                                    <x-tables.td class="py-1" x-text="item.name"></x-tables.td>
                                    <x-tables.td class="py-1" x-text="item.quantity"></x-tables.td>
                                    <x-tables.td class="py-1 text-right">
                                        <x-buttons.danger-button @click="removeItem(index)"
                                            type="button">Remove</x-buttons.danger-button>
                                    </x-tables.td>
                                </tr>
                            </template>
                        </x-tables.table>
                        {{-- <input type="hidden" name="ordered_items" :value="orderedItems"> --}}
                    </x-cards.body>
                </x-cards.card>
            @endif
        </div>

        @if (count($products) > 0)
            <!-- Only show if a product exists -->
            <x-cards.card>
                <x-cards.header :title="'Select Parent Product'" :description="'Select the parent product that this product belongs too'" />
                <x-cards.body>
                    Product Name
                    Type
                </x-cards.body>
            </x-cards.card>
        @endif

        @if (count($customerOptions) > 0)
            <x-cards.card>
                <x-cards.header :title="'Select Customer'" :description="'Select the customer this product belongs too'" />
                <x-cards.body>
                    <div x-data="{ choice: '{{ old('selected_customer_choice', null) }}' }">
                        <x-buttons.primary-button @click="choice = 'select'" type="button" class="w-full py-3">Select
                            Parent Customer</x-buttons.primary-button>

                        <input type="hidden" name="selected_customer_choice" x-bind:value="choice">

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_customer_id" :value="__('Select Customer')" />
                                <x-forms.select name="selected_customer_id" :options="$customerOptions" class="mt-1"
                                    x-bind:required="choice === 'select'"></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_customer_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                </x-cards.body>
            </x-cards.card>
        @endif

        <x-cards.card>
            <x-cards.body>
                <x-buttons.primary-button class="w-full">Create Product</x-buttons.primary-button>
            </x-cards.body>
        </x-cards.card>
    </form>

</section>
