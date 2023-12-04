<section>

    <form method="post" action="{{ route('warehouse.tenants.inventory.recipes.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create a Recipe'" :description="'Enter the details of your new recipe'" />
            <x-cards.body>

                <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                    <!-- Item Name -->
                    <div class="col-span-1">
                        <x-forms.input-label for="name" :value="__('Recipe Name')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    {{-- <div class="col-span-1">
                        <x-forms.input-label for="cyu" :value="__('Customer Type')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div> --}}
                </div>
            </x-cards.body>
        </x-cards.card>


        <div x-data="{ selectedBoxId: '', maxItems: 0, boxPackagingOptions: {{ Js::from($boxPackagings) }} }">
            <x-cards.card>
                <x-cards.header :title="'Box Type'" :description="'Select the type of box that this recipe will use'" />
                <x-cards.body>
                    <x-forms.base-select id="box_packaging" name="box_packaging" x-model="selectedBoxId"
                        @change="maxItems = boxPackagingOptions[selectedBoxId]?.maxItems">
                        >
                        <option value="" selected>Select a Box Type</option>

                        @foreach ($boxPackagings as $id => $option)
                            <option value="{{ $id }}">
                                {{ $option['name'] }} (Max Items: {{ $option['maxItems'] }})
                            </option>
                        @endforeach
                    </x-forms.base-select>
                </x-cards.body>
            </x-cards.card>


            <div class="grid grid-cols-1 gap-x-6">
                <div class="col-span-1 ">
                    <x-cards.card>
                        <x-cards.header :title="'Box Type'" :description="'Select the type of box that this recipe will use'" />
                        <x-cards.body>
                            <x-tables.table :headers="['Grams', 'Item', 'Item Packaging', 'Item Decoration']">
                                <tbody>
                                    <template x-for="(item, index) in Number(maxItems)" :key="index">
                                        <tr>
                                            <x-tables.td>
                                                <x-forms.text-input x-bind:id="'ounces' + index"
                                                    x-bind:name="'items[' + index + '][ounces]'" type="number" step="0.01"
                                                    placeholder="e.g., 10" class="block w-full mt-1" required />
                                            </x-tables.td>
                                            <x-tables.td>
                                                <x-forms.base-select x-bind:id="'item' + index"
                                                    x-bind:name="'items[' + index + '][item]'">
                                                    <option value="" selected>Select a Item</option>
                                                    @foreach ($inventoryItems as $id => $option)
                                                        <option value="{{ $id }}">
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </x-forms.base-select>
                                            </x-tables.td>
                                            <x-tables.td>
                                                <x-forms.base-select x-bind:id="'packaging' + index"
                                                    x-bind:name="'items[' + index + '][packaging]'">
                                                    <option value="" selected>Select a Item Packaging</option>
                                                    @foreach ($itemPackagings as $id => $option)
                                                        <option value="{{ $id }}">{{ $option }}</option>
                                                    @endforeach
                                                </x-forms.base-select>
                                            </x-tables.td>
                                            <x-tables.td>
                                                <x-forms.base-select x-bind:id="'decoration' + index"
                                                    x-bind:name="'items[' + index + '][decoration]'">
                                                    <option value="" selected>Select a Packaging Decoration
                                                    </option>
                                                    @foreach ($inventoryItems as $id => $option)
                                                        <option value="{{ $id }}">
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </x-forms.base-select>
                                            </x-tables.td>
                                        </tr>
                                    </template>
                                </tbody>
                            </x-tables.table>
                        </x-cards.body>
                    </x-cards.card>
                </div>
            </div>

        </div>

        <x-cards.card>
            <x-cards.body>
                <x-buttons.primary-button type="submit"
                    class="w-full p-2">{{ __('Create Inventory Item') }}</x-buttons.primary-button>
            </x-cards.body>
        </x-cards.card>
    </form>
</section>
