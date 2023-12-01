<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Recipes' => '#']" pageTitle="Recipes" />

        <x-cards.card>
            <x-cards.header :title="'Recipes'" :description="'A list of all items in the warehouse'">
                <x-buttons.link-button href="{{ route('warehouse.tenants.inventory.recipes.create') }}">Create
                    Recipe</x-buttons.link-button>
            </x-cards.header>
            <x-cards.body>
                <x-tables.table :headers="['Recipe Name', 'Status', 'Actions']">

                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <x-tables.td>

                                    {{ $recipe->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">
                                        Active
                                    </span>

                                </x-tables.td>
                                <x-tables.td class="flex justify-end space-x-2">

                                    <x-buttons.primary-button disabled>Edit</x-buttons.primary-button>
                                    <x-buttons.primary-button disabled>Duplicate</x-buttons.primary-button>
                                    @if ($warehouse->warehouseOwner->id == auth()->user()->id)
                                        <form action="{{ route('warehouse.tenants.inventory.recipes.delete', $recipe->id) }}"
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
