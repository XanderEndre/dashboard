<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Warehouse' => route('dashboard.index'), 'Edit Warehouse' => '#']" pageTitle="Modifying Warehouse" />

        <div class="grid gap-4 grid-cols-1">
            <div class="col-span-1">
                @include('warehouse.partials.update-warehouse-form')
            </div>
        </div>
    </div>

</x-app-layout>
