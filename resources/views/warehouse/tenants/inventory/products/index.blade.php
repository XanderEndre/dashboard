<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Inventory' => route('warehouse.inventory.index'), 'Products' => '#']" pageTitle="Products" />
        <x-cards.card>
            <x-cards.header :title="'Products'" :description="'A list of all products in the warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.inventory.products.create') }}">Create
                    Product</x-buttons.link-button></x-cards.header>
            <x-cards.body>
                @if ($products->count() > 0)
                    <x-tables.table :headers="['Cateogry Name', 'Parent Category', 'Status', 'Actions']">
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <x-tables.td>

                                        {{ $category->name }}
                                    </x-tables.td>
                                    <x-tables.td>
                                        @if ($category->parentCategory != null)
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 rounded-md bg-blue-50 ring-1 ring-inset ring-blue-600/20">
                                                {{ $category->parentCategory->name }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                                No Parent Category
                                            </span>
                                        @endif

                                    </x-tables.td>
                                    <x-tables.td>
                                        @if ($category->is_active)
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
                                    <x-tables.td class="text-right">

                                        <x-buttons.primary-button disabled>Modify</x-buttons.primary-button>

                                    </x-tables.td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-tables.table>
                @endif
            </x-cards.body>
        </x-cards.card>
    </div>
</x-app-layout>
