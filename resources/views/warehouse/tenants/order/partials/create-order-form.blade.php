<section>

    <form method="post" action="{{ route('warehouse.tenants.order.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create new Order'" :description="'Enter the details of your new order'" />
            <x-cards.body>

                <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                    <!-- Item Name -->
                    <div class="col-span-1">
                        <x-forms.input-label for="customer_id" :value="__('Customer')" required />
                        <x-forms.base-select name="customer_id" id="customer_id">
                            <option value="" selected>Select a Customer</option>
                            @foreach ($customers as $id => $option)
                                <option value="{{ $id }}">
                                    {{ $option }}
                                </option>
                            @endforeach
                        </x-forms.base-select>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>
                    <div class="col-span-1">
                        <x-forms.input-label for="po_number" :value="__('PO Number')" required />
                        <x-forms.text-input id="po_number" name="po_number" type="text" :value="old('po_number')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('po_number')" />
                    </div>
                    {{-- <div class="col-span-1">
                        <x-forms.input-label for="name" :value="__('Date Required')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div> --}}
                </div>
            </x-cards.body>
        </x-cards.card>

        <div x-data="{ items: [{ id: 1, recipe: '', quantity: '' }], removeItem(index) { this.items.splice(index, 1); } }">
            <x-cards.card>
                <x-cards.header :title="'Order Details'" :description="'Enter the details of your new order'">
                    <x-buttons.primary-button
                        @click.prevent="items.push({id: items.length + 1, recipe: '', quantity: ''})">Add
                        Recipe</x-buttons.primary-button>
                </x-cards.header>
                <x-cards.body>

                    <x-tables.table :headers="['Recipe', 'Quantity', 'Actions']">
                        <tbody>
                            <template x-for="(item, index) in items" :key="item.id">

                                <tr>
                                    <x-tables.td>
                                        <x-forms.base-select x-bind:id="'item' + index"
                                            x-bind:name="'items[' + index + '][item]'">
                                            <option value="" selected>Select Recipe</option>
                                            @foreach ($recipes as $id => $option)
                                                <option value="{{ $id }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </x-forms.base-select>
                                    </x-tables.td>
                                    <x-tables.td>
                                        <x-forms.text-input x-bind:id="'quantity' + index"
                                            x-bind:name="'items[' + index + '][quantity]'" type="text"
                                            placeholder="Enter Quantity" class="block w-full" required />
                                    </x-tables.td>
                                    {{-- <x-tables.td>
                                        <x-forms.text-input x-bind:id="'ounces' + index"
                                            x-bind:name="'items[' + index + '][ounces]'" type="text"
                                            placeholder="Enter Quantity" class="block w-full" disabled />
                                    </x-tables.td> --}}
                                    <x-tables.td class="flex justify-end">
                                        <x-buttons.danger-button
                                            @click.prevent="removeItem(index)">Remove</x-buttons.danger-button>
                                    </x-tables.td>
                                </tr>
                            </template>
                        </tbody>

                    </x-tables.table>

                </x-cards.body>
            </x-cards.card>
        </div>


        <x-cards.card>
            <x-cards.body>
                <x-buttons.primary-button type="submit"
                    class="w-full p-2">{{ __('Create Inventory Item') }}</x-buttons.primary-button>
            </x-cards.body>
        </x-cards.card>
    </form>
</section>
