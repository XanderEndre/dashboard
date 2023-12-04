<x-app-layout>
    <x-layout.breadcrumbs :links="['Vendors' => route('warehouse.tenants.vendor.index'), 'View' => '#']" pageTitle="Vendors" />

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-8 mb-5">
        <!-- Card -->
        <div class="col-span-4 md:col-span-1">
            <x-cards.card>
                <x-cards.header :title="$vendor->name" :description="$vendor->account_number" />
                <x-cards.body>
                    Date Created:
                    Date Modified:

                </x-cards.body>
            </x-cards.card>
            <x-cards.card>
                <x-cards.header :title="'Vendor Modification'" :description="'Modify this vendor'" />
                <x-cards.body>
                    <x-buttons.primary-button>Edit</x-buttons.primary-button>
                    <x-buttons.danger-button>Delete Vendor</x-buttons.danger-button>
                </x-cards.body>

            </x-cards.card>
        </div>
        <!-- Card -->
        <div class="md:col-span-3 col-span-4">

            <x-cards.card>
                <x-cards.header-simple :title="'Addresses'">
                    <div>
                        {{-- <x-address-modal route="{{  route('warehouse.tenants.vendor.store', $vendor) }}" :title="'Vendors'" :addressOptions="{{  $addressOptions }}" /> --}}
                        @include('warehouse.tenants.vendor.partials.add-address-form')
                    </div>
                </x-cards.header-simple>
                <x-cards.body>

                    <x-tables.table :headers="[
                        'Address Type',
                        'Address One',
                        'Address Two',
                        'City',
                        'State',
                        'Country',
                        'Zipcode',
                        'Actions',
                    ]">
                        @foreach ($vendor->addresses as $address)
                            <tr>
                                <x-tables.td>{{ $address->address_type }}</x-tables.td>
                                <x-tables.td>{{ $address->address }}</x-tables.td>
                                <x-tables.td>{{ $address->address_two }} </x-tables.td>
                                <x-tables.td>{{ $address->city }}</x-tables.td>
                                <x-tables.td>{{ $address->state }}</x-tables.td>
                                <x-tables.td>{{ $address->country }}</x-tables.td>
                                <x-tables.td>{{ $address->zipcode }}</x-tables.td>
                                <x-tables.td>
                                    <div class="flex space-x-2 items-center justify-end">
                                        <x-buttons.primary-button>
                                            <svg class="hi-mini hi-wrench inline-block w-5 h-5"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M19 5.5a4.5 4.5 0 01-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 11-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 015.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 00-.11.494 3.01 3.01 0 001.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382zM4 17a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-buttons.primary-button>
                                        <div>
                                            @include('warehouse.tenants.vendor.partials.remove-address')
                                        </div>
                                    </div>
                                </x-tables.td>
                            </tr>
                        @endforeach
                    </x-tables.table>
                </x-cards.body>
            </x-cards.card>


            <x-cards.card>
                <x-cards.header-simple :title="'Contact Information'">
                    <div>
                        @include('warehouse.tenants.vendor.partials.add-contact-form')
                    </div>

                </x-cards.header-simple>
                <x-cards.body>

                    <x-tables.table :headers="['Contact Name', 'Contact Email', 'Phone Number', 'Extension', 'Actions']">
                        @foreach ($vendor->contacts as $contact)
                            <tr>
                                <x-tables.td>{{ $contact->first_name }}
                                    {{ $contact->last_name }}</x-tables.td>
                                <x-tables.td>{{ $contact->email }}</x-tables.td>
                                <x-tables.td>{{ $contact->phone_number }}</x-tables.td>
                                <x-tables.td>{{ $contact->extension }}</x-tables.td>
                                <x-tables.td>
                                    <div class="flex space-x-2 items-center justify-end">
                                        <x-buttons.primary-button>
                                            <svg class="hi-mini hi-wrench inline-block w-5 h-5"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M19 5.5a4.5 4.5 0 01-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 11-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 015.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 00-.11.494 3.01 3.01 0 001.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382zM4 17a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-buttons.primary-button>
                                        <div>
                                            @include('warehouse.tenants.vendor.partials.remove-contact')
                                        </div>
                                    </div>
                                </x-tables.td>
                            </tr>
                        @endforeach
                    </x-tables.table>
                </x-cards.body>
            </x-cards.card>

            <x-cards.card>
                <x-cards.header-simple :title="'Inventory Items'">
                    <div>
                        {{-- <x-buttons.primary-button>Add </x-buttons.primary-button> --}}
                    </div>

                </x-cards.header-simple>
                <x-cards.body>

                    <x-tables.table :headers="['Order Id', 'Order Recipe #', 'Status', 'STATUS', 'VALUE', 'Actions']">
                        <tr>
                            <x-tables.td>1</x-tables.td>
                            <x-tables.td>123</x-tables.td>
                            <x-tables.td>11-29-2023</x-tables.td>
                            <x-tables.td>DELIVERED</x-tables.td>
                            <x-tables.td>$2,002.32</x-tables.td>
                            <x-tables.td class="text-right">
                                <x-buttons.primary-button>
                                    <svg class="hi-mini hi-eye inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-buttons.primary-button>
                                <x-buttons.secondary-button>
                                    <svg class="hi-mini hi-wrench inline-block w-5 h-5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M19 5.5a4.5 4.5 0 01-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 11-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 015.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 00-.11.494 3.01 3.01 0 001.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382zM4 17a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-buttons.secondary-button>
                            </x-tables.td>
                        </tr>
                    </x-tables.table>
                </x-cards.body>
            </x-cards.card>
        </div>

    </div>

</x-app-layout>
