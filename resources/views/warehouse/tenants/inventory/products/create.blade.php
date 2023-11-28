<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="[
            'Inventory' => route('warehouse.inventory.index'),
            'Products' => route('warehouse.inventory.products.index'),
            'Create' => '#',
        ]" pageTitle="Create Product" />

        @include('warehouse.inventory.products.partials.create-product-form')
    </div>
</x-app-layout>
