<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="['Vendors' => route('warehouse.vendor.index'), 'Create' => '#']" pageTitle="Vendors" />
        @include('warehouse.vendor.partials.create-vendor-form')
    </div>
</x-app-layout>
