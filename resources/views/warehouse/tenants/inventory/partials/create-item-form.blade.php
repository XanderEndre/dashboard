<section>

    <form method="post" action="{{ route('warehouse.tenants.inventory.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create an Item'" :description="'Enter the details of your new item'" />
            <x-cards.body>

                <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                    <!-- Item Name -->
                    <div class="col-span-1">
                        <x-forms.input-label for="name" :value="__('Item Name')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="col-span-1">
                        <x-forms.input-label for="vendor_name" :value="__('Vendor Item Name')" required />
                        <x-forms.text-input id="vendor_name" name="vendor_name" type="text"
                            :value="old('vendor_name')" placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('vendor_name')" />
                    </div>

                    <!-- Category Description -->
                    <div class="col-span-1 md:col-span-2">
                        <x-forms.input-label for="description" :value="__('Item Description')" required />
                        <textarea id="description" name="description"
                            class="mt-1 w-full block border placeholder-gray-500 px-5 py-3 leading-6 rounded-lg border-gray-200 focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-primary-500 dark:placeholder-gray-400"
                            placeholder="e.g., Net 30 days" rows="4" required>{{ old('description') }}</textarea>
                        <x-forms.input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>


                    <div class="col-span-1">
                        <x-forms.input-label for="cost" :value="__('Item Cost')" required />
                        <x-forms.text-input id="cost" name="cost" type="text" :value="old('cost')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('cost')" />
                    </div>

                    <div class="col-span-1">
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

        {{-- <x-cards.card>
            <x-cards.header :title="'Item Category'" :description="'Select the category that this item belongs too'" />
            <x-cards.body>
                <x-forms.input-label for="selected_category_id" :value="__('Select Category')" />
                <x-forms.select name="selected_category_id" :options="$categoryOptions" class="mt-1"></x-forms.select>
                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_category_id')" />
            </x-cards.body>
            <x-cards.footer>
                *This is field is required.
            </x-cards.footer>
        </x-cards.card> --}}

        {{-- @if (count($vendorOptions) > 0)
            <x-cards.card>
                <x-cards.header :title="'Item Vendor'" :description="'Select the vendor that this item belongs too'" />
                <x-cards.body>
                    <div x-data="{ choice: '{{ old('vendor_choice', null) }}' }">
                        <x-buttons.primary-button @click="choice = 'select'" type="button" class="w-full py-3">Select
                            Item Vendor</x-buttons.primary-button>

                        <input type="hidden" name="vendor_choice" x-bind:value="choice">

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_vendor_id" :value="__('Select Parent Customer')" />
                                <x-forms.select name="selected_vendor_id" :options="$vendorOptions" class="mt-1"
                                    x-bind:required="choice === 'select'"></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_vendor_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                </x-cards.body>
            </x-cards.card>
        @endif --}}
        {{-- 
        @if (count($substituteItemOptions) > 0)
            <x-cards.card>
                <x-cards.header :title="'Substitute Item'" :description="'Select the substitute item of this item'" />
                <x-cards.body>
                    <div x-data="{ choice: '{{ old('parent_item_choice', null) }}' }">
                        <x-buttons.primary-button @click="choice = 'select'" type="button" class="w-full py-3">Select
                            Substitute Item</x-buttons.primary-button>

                        <input type="hidden" name="parent_item_choice" x-bind:value="choice">

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_sub_item_id" :value="__('Select Substitute Item')" />
                                <x-forms.select name="selected_sub_item_id" :options="$substituteItemOptions" class="mt-1"
                                    x-bind:required="choice === 'select'"></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_sub_item_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                </x-cards.body>
            </x-cards.card>
        @endif --}}

        {{-- <x-cards.card>
            <x-cards.header :title="'Item Details'" :description="'Select the individal details that correlate to this item'" />

            <x-cards.body>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Item Type -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_type" :value="__('Item Type')" />
                        <x-forms.select name="item_type" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemType" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_type" class="mt-2" :messages="$errors->get('item_type')" />
                    </div>

                    <!-- Item Dirty Level -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_dirty_level" :value="__('Item Dirty Level')" />
                        <x-forms.select name="item_dirty_level" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemDirtyLevel" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_dirty_level" class="mt-2" :messages="$errors->get('item_dirty_level')" />
                    </div>

                    <!-- Item Tracking Option -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_trk_option" :value="__('Item Tracking Option')" />
                        <x-forms.select name="item_trk_option" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemTrkOption" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_trk_option" class="mt-2" :messages="$errors->get('item_trk_option')" />
                    </div>

                    <!-- Item Valuation Method -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_valuation_method" :value="__('Item Valuation Method')" />
                        <x-forms.select name="item_valuation_method" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemValuationMethod" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_valuation_method" class="mt-2" :messages="$errors->get('item_valuation_method')" />
                    </div>

                    <!-- Item Unit Of Measure -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_unit_of_measure" :value="__('Item Unit Of Measure')" />
                        <x-forms.select name="item_unit_of_measure" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemUnitOfMeasure" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_unit_of_measure" class="mt-2" :messages="$errors->get('item_unit_of_measure')" />
                    </div>

                    <!-- Item Purchase Tax Option -->
                    <div class="col-span-1">
                        <x-forms.input-label for="item_purchase_tax_option" :value="__('Item Purchase Tax Option')" />
                        <x-forms.select name="item_purchase_tax_option" :options="App\Models\Warehouse\Inventory\InventoryItem::$itemPurchaseTaxOptions" :useOptionsAsValue="true"
                            class="mt-1"></x-forms.select>
                        <x-forms.input-error for="item_purchase_tax_option" class="mt-2" :messages="$errors->get('item_purchase_tax_option')" />
                    </div>
                </div>
            </x-cards.body>
        </x-cards.card> --}}

        <x-cards.card>
            <x-cards.body>
                <x-buttons.primary-button type="submit"
                    class="w-full p-2">{{ __('Create Inventory Item') }}</x-buttons.primary-button>
            </x-cards.body>
        </x-cards.card>
    </form>
</section>
