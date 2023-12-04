<section>

    <form method="post" action="{{ route('warehouse.tenants.inventory.recipes.item.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create Packaging'" :description="'Enter the details of your new item'" />
            <x-cards.body>

                <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                    <!-- Item Name -->
                    <div class="col-span-1">
                        <x-forms.input-label for="name" :value="__('Packaging Name')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
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


        <x-cards.card>
            <x-cards.header-simple :title="'Item Pricing'" />
            <x-cards.body>
                <div class="grid grid-cols-1 gap-6">
                    <div class="col-span-1">
                        <x-forms.input-label for="total_cost" :value="__('Cost Per Unit')" required />
                        <x-forms.text-input id="total_cost" name="total_cost" type="number" :value="old('total_cost')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required step="0.01" />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('total_cost')" />
                    </div>
    
                </div>
            </x-cards.body>
            <x-cards.footer>
                *This is field is required.
            </x-cards.footer>
        </x-cards.card>

        <x-cards.card>
            <x-cards.body>
                <x-buttons.primary-button type="submit"
                    class="w-full p-2">{{ __('Create Inventory Item') }}</x-buttons.primary-button>
            </x-cards.body>
        </x-cards.card>
    </form>
</section>
