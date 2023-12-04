<x-app-layout>
    <x-layout.breadcrumbs :links="['Orders' => route('warehouse.tenants.order.index'), 'View' => '#']" pageTitle="Orders" />

    <div class="grid grid-cols-1  gap-4 lg:gap-8 mb-5">
        <!-- Card -->
        <!-- Card -->
        <div class="col-span-1">

            <x-cards.card>
                <x-cards.header-simple :title="'Order'">
                    <div>
                        {{-- <x-address-modal route="{{  route('warehouse.tenants.vendor.store', $vendor) }}" :title="'Vendors'" :addressOptions="{{  $addressOptions }}" /> --}}
                        {{-- @include('warehouse.tenants.vendor.partials.add-address-form') --}}
                    </div>
                </x-cards.header-simple>
                <x-cards.body>
                    <x-tables.table :headers="['Order Id', 'Customer', 'P.O. Number', 'Total Cost', 'Status', 'Date Due']">

                        <tbody>

                            <tr class="even:bg-gray-100 dark:even:bg-gray-900/50"">
                                <x-tables.td>
                                    {{ $order->id }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $order->customer->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $order->po_number }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ number_format($order->total_cost, 2) }} <!-- Format as currency -->
                                </x-tables.td>
                                <x-tables.td>
                                    <x-badges.badge :state="$order->order_state" />
                                    {{-- {{ $order->order_state }} --}}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $order->expected_delivery_date }} <!-- Format date -->
                                </x-tables.td>


                            </tr>

                        </tbody>
                    </x-tables.table>
                </x-cards.body>
            </x-cards.card>


            <x-cards.card>
                <x-cards.header-simple :title="'Order Details'" />
                <x-cards.body>
                    <x-tables.table :headers="['Quantity', 'Recipe Name', 'Recipe Packaging', '# Of Items', 'Actions']">
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <x-tables.td>
                                    {{ $detail->quantity }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $detail->recipes->name }}
                                </x-tables.td>

                                <x-tables.td>
                                    {{ $detail->recipes->boxPackaging->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $detail->recipes->boxPackaging->max_item_quantity }}
                                </x-tables.td>
                                <x-tables.td class="text-right">
                                    <x-buttons.primary-button>
                                        View Contents
                                    </x-buttons.primary-button>
                                </x-tables.td>
                            </tr>
                        @endforeach
                    </x-tables.table>
                    {{-- <x-tables.table :headers="['Contact Name', 'Contact Email', 'Phone Number', 'Extension', 'Actions']">
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
                    </x-tables.table> --}}
                </x-cards.body>
            </x-cards.card>

        </div>

    </div>

</x-app-layout>
