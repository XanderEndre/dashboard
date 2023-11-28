<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="[
            'Inventory' => route('warehouse.inventory.index'),
            'Items' => route('warehouse.inventory.items.index'),
            'Create' => '#',
        ]" pageTitle="Create Item" />

        @include('warehouse.inventory.items.partials.create-item-form')
    </div>
</x-app-layout>
