<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Inventory' => '#']" pageTitle="Inventory" />

        <x-cards.card>
            <x-cards.header :title="'Inventory Items'" :description="'A list of all items in the warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.tenants.inventory.create') }}">Create
                    Inventory Item</x-buttons.link-button>
            </x-cards.header>
            <x-cards.body>
                <x-tables.table :headers="['Item Name', 'Substitute Item', 'Vendor', 'Status', 'Cost Per Unit', 'Actions']">

                    <tbody>
                        @foreach ($inventoryItems as $item)
                            <tr>
                                <x-tables.td>

                                    {{ $item->name }}
                                </x-tables.td>

                                <x-tables.td>
                                    @if ($item->substituteItem != null)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 rounded-md bg-indigo-50 ring-1 ring-inset ring-indigo-600/20">
                                            {{ $item->substituteItem->name }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                            No Substitute Item
                                        </span>
                                    @endif
                                </x-tables.td>
                                <x-tables.td>
                                    @if ($item->vendor)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 rounded-md bg-blue-50 ring-1 ring-inset ring-blue-600/20">
                                            {{ $item->vendor->name }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                            No Vendor
                                        </span>
                                    @endif
                                </x-tables.td>
                                <x-tables.td>
                                    @if ($item->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                            Inactive
                                        </span>
                                    @endif
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $item->total_cost }}
                                </x-tables.td>
                                <x-tables.td class="text-right flex space-x-2 items-center justify-end">
                                    <x-buttons.tooltip :tooltip="'View Item'" :position="'left'">
                                        <x-buttons.link-button
                                            href="{{ route('warehouse.tenants.inventory.show', $item) }}">
                                            <svg class="hi-mini hi-eye inline-block w-5 h-5"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                <path fill-rule="evenodd"
                                                    d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-buttons.link-button>
                                    </x-buttons.tooltip>
                                    {{-- <x-buttons.tooltip :tooltip="'Delete Item'" :position="'left'">
                                        <div>
                                            {{-- @include('warehouse.tenants.vendor.partials.delete-vendor-form') -
                                        </div>
                                    </x-buttons.tooltip> --}}

                                </x-tables.td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-tables.table>
            </x-cards.body>
        </x-cards.card>

    </div>
</x-app-layout>
