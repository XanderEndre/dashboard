<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Order' => '#']" pageTitle="Items" />
        <x-cards.card>
            <x-cards.header :title="'Orders'" :description="'A categoriezed list of all orders in the warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.tenants.order.create') }}">Create
                    Order</x-buttons.link-button>
            </x-cards.header>
            <x-cards.body>
                <x-tables.table :headers="['Customer', 'P.O. Number', 'Actions']">

                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <x-tables.td>
                                    {{ $order->customer->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $order->po_number }}
                                </x-tables.td>

                                <x-tables.td class="flex justify-end space-x-2">

                                    <x-buttons.primary-button disabled>Edit</x-buttons.primary-button>
                                    <x-buttons.primary-button disabled>Duplicate</x-buttons.primary-button>
                                    @if ($warehouse->warehouseOwner->id == auth()->user()->id)
                                        <form action="{{ route('warehouse.tenants.order.delete', $order->id) }}"
                                            method="POST">
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

{{-- 

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    <span
                        class="inline-flex items-center px-2 py-1 font-medium text-blue-700 rounded-md bg-blue-50 ring-1 ring-inset ring-blue-700/10">{{ $warehouse->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div>
        <x-layout.breadcrumbs :links="['Inventory' => route('warehouse.inventory.index'), 'Items' => '#']" pageTitle="Items" />
        <div class="grid gap-4 lg:grid-cols-12 md:grid-cols-12">
            <div class="lg:col-span-12 md:col-span-12">
                <x-cards.card>
                    @if ($items->count() > 0)

                        <div class="mx-auto">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h2 class="text-xl font-semibold">
                                        {{ Str::plural('Item', $items->count()) }}
                                    </h2>
                                </div>
                                <div>
                                    <x-buttons.link-button href="{{ route('warehouse.inventory.items.create') }}">Create
                                        Item</x-buttons.link-button>
                                </div>
                            </div>
                        </div>
                        @foreach ($categories as $category)
                            <table class="min-w-full divide-y divide-gray-300 rounded-lg ring-1 ring-gray-300 mb-3">
                                <thead class="bg-blue-100 rounded-lg ">
                                    <tr>
                                        <th scope="col"
                                            class="w-1/4 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 
                                rounded-tl-lg">
                                            {{ $category->name }}
                                            {{ $category->parentCategory != null ? '(' . $category->parentCategory->name . ')' : '' }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Parent Item</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Vendor</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Status</th>
                                        <th scope="col" class="py-3.5 pl-3 pr-4 sm:pr-6 rounded-tr-lg text-right">
                                            Options
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->inventoryItems as $item)
                                        <tr>
                                            <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                <div class="font-medium text-gray-900">
                                                    {{ $item->item_name }} </div>
                                            </td>

                                            <td class="px-3 py-3.5">
                                                @if ($item->parentItem != null)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 rounded-md bg-indigo-50 ring-1 ring-inset ring-indigo-600/20">
                                                        {{ $item->parentItem->item_name }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                                        No Parent Item
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3.5">
                                                @if ($item->vendor)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 rounded-md bg-blue-50 ring-1 ring-inset ring-blue-600/20">
                                                        {{ $item->vendor->vendor_name }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                                        No Vendor
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3.5">
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
                                            </td>
                                            <td
                                                class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">

                                                <x-buttons.primary-button disabled>Edit</x-buttons.primary-button>
                                                <x-buttons.primary-button disabled>Duplicate</x-buttons.primary-button>
                                                <x-buttons.danger-button disabled>Remove</x-buttons.danger-button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @else
                        <div class="mx-auto">
                            <div class="p-8 border border-dashed rounded-md border-slate-300">
                                <div class="font-medium text-center">
                                    There are no Items in this warehouse.
                                </div>
                                <div class="text-center">
                                    <a class="text-indigo-500 hover:underline"
                                        href=" {{ route('warehouse.inventory.items.create') }}">Create an Item!</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- @if ($items->count() > 0)
                        <div class="mx-auto">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h2 class="text-xl font-semibold">
                                        {{ Str::plural('Item', $items->count()) }}
                                    </h2>
                                </div>
                                <div>
                                    <x-buttons.link-button href="{{ route('warehouse.inventory.items.create') }}">Create
                                        Item</x-buttons.link-button>
                                </div>
                            </div>
                        </div>
                        <x-tables.table>
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Item Name
                                    </th>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Item Short Name
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Category
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right">
                                        Options
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="even:bg-slate-100">
                                        <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="font-medium text-gray-900">
                                                {{ $item->item_name }}
                                            </div>
                                        </td>
                                        <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="font-medium text-gray-900">
                                                {{ $item->vendor_item_name }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            @if ($item->category != null)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 rounded-md bg-blue-50 ring-1 ring-inset ring-blue-600/20">
                                                    {{ $item->category->name }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                                    No Parent Category
                                                </span>
                                            @endif

                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
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

                                        </td>
                                        <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">

                                            <x-buttons.primary-button disabled>View Details</x-buttons.primary-button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-tables.table>
                    @else
                        <div class="mx-auto">
                            <div class="p-8 border border-dashed rounded-md border-slate-300">
                                <div class="font-medium text-center">
                                    There are no Items in this warehouse.
                                </div>
                                <div class="text-center">
                                    <a class="text-indigo-500 hover:underline"
                                        href=" {{ route('warehouse.inventory.items.create') }}">Create an Item!</a>
                                </div>
                            </div>
                        </div>
                    @endif -
                </x-cards.card>
            </div>
        </div>

    </div>
</x-app-layout> --}}
