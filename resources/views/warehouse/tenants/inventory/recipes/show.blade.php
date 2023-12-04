<x-app-layout>
    <x-layout.breadcrumbs :links="['Vendors' => route('warehouse.tenants.vendor.index'), 'View' => '#']" pageTitle="Vendors" />

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-8 mb-5">
        <!-- Card -->
        <div class="col-span-4 md:col-span-1">
            <x-cards.card>
                <x-cards.header :title="$recipe->name" :description="'Last Updated ' . \Carbon\Carbon::parse($recipe->updated_at)->diffForHumans()" />
                    <x-cards.body>
                        Total Cost: ${{  $recipe->total_cost }}
                    </x-cards.body>
            </x-cards.card>
        </div>
        <!-- Card -->
        <div class="md:col-span-3 col-span-4">

            <x-cards.card>
                <x-cards.header-simple :title="'Recipe Items'" />
                <x-cards.body>
                    <x-tables.table :headers="['Grams', 'Item Name', 'Packaging', 'Decorations', 'Total Cost', 'Actions']">
                        @foreach ($recipe->recipeItems as $item)
                            <tr>
                                <x-tables.td>{{ $item->ounces }}</x-tables.td>
                                <x-tables.td>{{ $item->item->name }}</x-tables.td>
                                <x-tables.td>{{ $item->packaging->name }}</x-tables.td>
                                <x-tables.td>None</x-tables.td>
                                <x-tables.td>{{ $item->total_cost }}</x-tables.td>
                                <x-tables.td class="text-right">
                                    <x-buttons.primary-button>
                                        <svg class="hi-mini hi-eye inline-block w-5 h-5"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                            <path fill-rule="evenodd"
                                                d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-buttons.primary-button>
                                    <x-buttons.secondary-button>
                                        <svg class="hi-mini hi-wrench inline-block w-5 h-5"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M19 5.5a4.5 4.5 0 01-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 11-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 015.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 00-.11.494 3.01 3.01 0 001.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382zM4 17a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-buttons.secondary-button>
                                </x-tables.td>
                            </tr>
                        @endforeach
                    </x-tables.table>
                </x-cards.body>
            </x-cards.card>



            <x-cards.card>
                <x-cards.header-simple :title="'Recipe Packaging'" />
                <x-cards.body>
                    <div>
                        <x-tables.table :headers="['Packaging Name', 'Max Items', 'Total Cost', 'Actions']">
                            {{-- @foreach ($recipe->boxPackaging as $box) --}}
                            <tr>
                                <x-tables.td>{{ $recipe->boxPackaging->name }}</x-tables.td>
                                <x-tables.td>{{ $recipe->boxPackaging->max_item_quantity }}</x-tables.td>
                                <x-tables.td>{{ $recipe->boxPackaging->total_cost }}</x-tables.td>

                                <x-tables.td class="text-right">
                                    <x-buttons.primary-button>
                                        <svg class="hi-mini hi-eye inline-block w-5 h-5"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                            <path fill-rule="evenodd"
                                                d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-buttons.primary-button>
                                    <x-buttons.secondary-button>
                                        <svg class="hi-mini hi-wrench inline-block w-5 h-5"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M19 5.5a4.5 4.5 0 01-4.791 4.49c-.873-.055-1.808.128-2.368.8l-6.024 7.23a2.724 2.724 0 11-3.837-3.837L9.21 8.16c.672-.56.855-1.495.8-2.368a4.5 4.5 0 015.873-4.575c.324.105.39.51.15.752L13.34 4.66a.455.455 0 00-.11.494 3.01 3.01 0 001.617 1.617c.17.07.363.02.493-.111l2.692-2.692c.241-.241.647-.174.752.15.14.435.216.9.216 1.382zM4 17a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-buttons.secondary-button>
                                </x-tables.td>
                            </tr>
                            {{-- @endforeach --}}
                        </x-tables.table>
                    </div>
                </x-cards.body>

            </x-cards.card>
        </div>

    </div>

</x-app-layout>
