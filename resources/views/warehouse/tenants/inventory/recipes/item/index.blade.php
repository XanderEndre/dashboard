<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Recipes' => '#', 'Packaging' => '#']" pageTitle="Item Packaging" />

        <x-cards.card>
            <x-cards.header :title="'Item Packaging'" :description="'The types of packaging for individual items in this warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.tenants.inventory.recipes.item.create') }}">Create
                    Packaging</x-buttons.link-button>
            </x-cards.header>
            <x-cards.body>
                <x-tables.table :headers="['Packaging Name', 'Cost Per Unit', 'Actions']">

                    <tbody>
                        @foreach ($packagings as $packaging)
                            <tr>
                                <x-tables.td>
                                    {{ $packaging->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $packaging->total_cost }}
                                </x-tables.td>

                

                                <x-tables.td class="flex justify-end space-x-2">

                                    <x-buttons.primary-button disabled>Edit</x-buttons.primary-button>
                                    <x-buttons.primary-button disabled>Duplicate</x-buttons.primary-button>
                                    @if ($warehouse->warehouseOwner->id == auth()->user()->id)
                                        <form action="{{ route('warehouse.tenants.inventory.recipes.item.delete', $packaging->id) }}"
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
