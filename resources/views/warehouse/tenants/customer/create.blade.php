<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Customers' => route('warehouse.tenants.customer.index'), 'Create' => '#']" pageTitle="Customers" />
        <div class="grid gap-4 lg:grid-cols-12 md:grid-cols-12">
            <div class="lg:col-span-12 md:col-span-12">
                <div class="md:mb-5 md:col-span-12 sm:col-span-1">
                    @include('warehouse.tenants.customer.partials.create-customer-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
