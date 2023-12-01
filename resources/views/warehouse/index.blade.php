<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="['Warehouses' => route('warehouse.index')]" pageTitle="View Warehouses" />

        <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 gap-4 lg:gap-8">

            <div class="col-span-3">
                @if ($warehouseUserInvitations->count() > 0)
                    <x-cards.card class="mb-5">
                        <x-cards.header :title="Str::plural('Warehouse', $warehouseEmployeeOf->count()) .
                            ' ' .
                            Str::plural('Invitations', $warehouseUserInvitations->count())" :description="'A list of all warehouses with pending invitations'" />
                        <x-cards.body>
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Warehouse Name
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Received
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right">
                                            Options
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouseUserInvitations as $invitation)
                                        <tr>
                                            <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="font-medium text-gray-900">
                                                            {{ $invitation->warehouse->name }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">

                                                {{ \Carbon\Carbon::parse($invitation->updated_at)->diffForHumans() }}
                                            </td>
                                            <td
                                                class="relative pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">

                                                <div class="flex items-center justify-end space-x-2">
                                                    <form method="GET"
                                                        action="{{ route('warehouse.invitation.accept.token', $invitation->invitation_token) }}">
                                                        @csrf
                                                        <x-buttons.primary-button>
                                                            {{ __('Accept Invitation') }}
                                                        </x-buttons.primary-button>
                                                    </form>
                                                    <form method="GET"
                                                        action="{{ route('warehouse.invitation.decline.token', $invitation->invitation_token) }}">
                                                        @csrf
                                                        <x-buttons.danger-button>
                                                            {{ __('Decline Invitation') }}
                                                        </x-buttons.danger-button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-cards.body>
                    </x-cards.card>
                @endif

                <x-cards.card>
                    <x-cards.header :title="Str::plural('Warehouse', $warehouseEmployeeOf->count())" :description="'A list of warehouse\'s you are apart '">
                        <x-buttons.link-button href="{{ route('warehouse.create') }}">Create
                            Warehouse</x-buttons.link-button>
                    </x-cards.header>
                    <x-cards.body>
                        @if ($warehouseEmployeeOf->count() > 0)
                            <!-- Tables: Striped -->
                            <!-- Responsive Table Container -->
                            <div
                                class="border border-gray-200 rounded overflow-x-auto min-w-full bg-white dark:bg-gray-800 dark:border-gray-700">
                                <!-- Table -->
                                <table class="min-w-full text-sm align-middle whitespace-nowrap">
                                    <!-- Table Header -->
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-left dark:text-gray-50 dark:bg-gray-700/25">
                                                Warehouse
                                            </th>
                                            <th
                                                class="px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-left dark:text-gray-50 dark:bg-gray-700/25">
                                                Role
                                            </th>
                                            <th
                                                class="px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-right dark:text-gray-50 dark:bg-gray-700/25">
                                                Options
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- END Table Header -->

                                    <!-- Table Body -->
                                    <tbody>
                                        @foreach ($warehouseEmployeeOf as $warehouse)
                                            <tr class="even:bg-gray-50 dark:even:bg-gray-900/50">
                                                <td class="p-3 text-left">
                                                    {{ $warehouse->name }}
                                                </td>
                                                <td class="p-3">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 font-medium text-orange-700 rounded-md bg-orange-50 ring-1 ring-inset ring-orange-700/10">
                                                        {{-- {{ $warehouse->warehouseEmployees->first()->role->role_name ?? 'NA' }} --}}
                                                    </span>

                                                </td>
                                                <td class="p-3 flex justify-end space-x-2">
                                                    @if ($user->active_schema != $warehouse->id)
                                                        <form action="{{ route('warehouse.activate', $warehouse->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <x-buttons.primary-button>Choose</x-buttons.primary-button>

                                                        </form>
                                                        @if ($warehouse->warehouseOwner->id == auth()->user()->id)
                                                            <form
                                                                action="{{ route('warehouse.destroy', $warehouse) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-buttons.danger-button>Remove</x-buttons.danger-button>

                                                            </form>
                                                        @endif
                                                    @else
                                                        <x-buttons.primary-button
                                                            disabled>Selected</x-buttons.primary-button>
                                                        @if ($user->id == $warehouse->warehouse_owner_id)
                                                            <x-buttons.link-button
                                                                href="{{ route('warehouse.edit') }}">View</x-buttons.link-button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <!-- END Table Body -->
                                </table>
                                <!-- END Table -->
                            </div>
                            <!-- END Responsive Table Container -->
                            <!-- END Tables: Striped -->
                        @else
                            <div
                                class="text-center w-full items-center justify-center rounded-xl border-2 border-dashed border-red-200 text-black dark:text-white py-16  dark:border-gray-500 space-y-2">
                                <p>You are currently not part of any warehouses.</p>
                                <p>
                                    Join an existing warehouse by requesting an invitation or create a new one today!
                                </p>
                                <x-buttons.link-button href="{{ route('warehouse.create') }}">Create
                                    Warehouse</x-buttons.link-button>
                            </div>
                        @endif
                    </x-cards.body>
                </x-cards.card>
            </div>
        </div>
    </div>
</x-app-layout>
