<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="[
            'Inventory' => route('warehouse.tenants.inventory.index'),
            'Items' => route('warehouse.tenants.inventory.index'),
            'Create' => '#',
        ]" pageTitle="Create Item" />

        @include('warehouse.tenants.inventory.recipes.box.partials.create-packaging-form')
    </div>
</x-app-layout>
