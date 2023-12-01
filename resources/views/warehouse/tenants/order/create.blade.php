<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="[
            'Orders' => route('warehouse.tenants.order.create'),
            'Create' => '#',
        ]" pageTitle="Create Order" />

        @include('warehouse.tenants.order.partials.create-order-form')
    </div>
</x-app-layout>
