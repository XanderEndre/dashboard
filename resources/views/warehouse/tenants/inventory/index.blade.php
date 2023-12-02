<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Inventory' => '#']" pageTitle="Inventory" />

        <x-cards.card>
            <x-cards.header :title="'Inventory Items'" :description="'A list of all items in the warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.tenants.inventory.create') }}">Create
                    Inventory Item</x-buttons.link-button>
            </x-cards.header>
            <x-cards.body>
                <x-tables.table :headers="['Item Name', 'Substitute Item', 'Vendor', 'Status', 'Actions']">

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
                                <x-tables.td class="flex justify-end space-x-2">

                                    <x-buttons.primary-button disabled>Edit</x-buttons.primary-button>
                                    <x-buttons.primary-button disabled>Duplicate</x-buttons.primary-button>
                                    @if ($warehouse->warehouseOwner->id == auth()->user()->id)
                                        <form action="{{ route('warehouse.tenants.inventory.delete', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-buttons.danger-button>Remove</x-buttons.danger-button>

                                        </form>
                                    @endif
                                </x-tables.td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-tables.table>
            </x-cards.body>
        </x-cards.card>

    </div>
</x-app-layout>
