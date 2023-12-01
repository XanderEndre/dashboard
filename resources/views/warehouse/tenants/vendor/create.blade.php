<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="['Vendors' => route('warehouse.tenants.vendor.index'), 'Create' => '#']" pageTitle="Vendors" />
        @include('warehouse.tenants.vendor.partials.create-vendor-form')
    </div>
</x-app-layout>
