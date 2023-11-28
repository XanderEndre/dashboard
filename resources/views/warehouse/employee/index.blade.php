<x-app-layout>

    <div>
        <x-layout.breadcrumbs :links="['Warehouse' => route('dashboard.index'), 'Employees' => '#']" pageTitle="Modifying Warehouse Employees" />

        <div class="grid gap-4 grid-cols-3">
            <div class="md:col-span-2 col-span-3">
                @if ($warehouseUserInvitations->count() > 0)
                    <x-cards.card>
                        <x-cards.header :title="'Employee' . ' ' . Str::plural('Invitation', $warehouseUserInvitations->count())" :description="'A list of employees with pending invitations'" />
                        <x-cards.body>
                            <x-tables.table :headers="['Email', 'Status', 'Expiry', 'Actions']">
                                @foreach ($warehouseUserInvitations as $invitation)
                                    <tr>
                                        <td class="text-black dark:text-white px-3 py-5">
                                            {{ $invitation->email }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 rounded-md bg-indigo-50 ring-1 ring-inset ring-indigo-600/20">
                                                {{ $invitation->status }}
                                            </span>

                                        </td>
                                        <td class="px-3 py-5 text-black dark:text-white whitespace-nowrap ">

                                            {{ \Carbon\Carbon::parse($invitation->expires_at)->diffForHumans() }}
                                        </td>
                                        <td class="py-4 px-3">
                                            <div class="flex items-center justify-end space-x-2">

                                                {{ $invitation->token }}
                                                <form method="POST"
                                                    action="{{ route('warehouse.invitation.cancel.token', ['token' => $invitation->invitation_token]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-buttons.danger-button>
                                                        {{ __('Cancel Invitation') }}
                                                    </x-buttons.danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-tables.table>
                        </x-cards.body>
                    </x-cards.card>
                @endif

                <x-cards.card>
                    <x-cards.header :title="Str::plural('Employee', $warehouse->warehouseUsers()->count())" :description="'A list of employees in this warehouse.'">
                        <x-buttons.link-button href="{{ route('warehouse.employee.create') }}">Add
                            Employee</x-buttons.link-button>
                    </x-cards.header>
                    <x-cards.body>
                        <x-tables.table :headers="['Name', 'Status', 'Role', 'Actions']">
                            @forelse ($warehouse->warehouseUsers as $employee)
                                <tr>
                                    <x-tables.td>
                                        <div class="flex items-center">
                                            <div>
                                                <div class="font-medium">{{ $employee->user->name }}
                                                </div>
                                                <div class="mt-1 text-primary-300">{{ $employee->user->email }}</div>
                                            </div>
                                        </div>
                                    </x-tables.td>
                                    <x-tables.td>
                                        @if ($employee->is_active)
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                                Inactive
                                            </span>
                                        @endif
                                    </x-tables.td>

                                    <x-tables.td>
                                        {{-- {{ $employee->role->name }} --}}
                                    </x-tables.td>

                                    <x-tables.td class="text-right">
                                        <x-buttons.primary-button>Edit</x-buttons.primary-button>
                                        @if ($employee->user_id != $warehouse->warehouse_owner_id)
                                            <form method="POST"
                                                action="{{ route('warehouse.employee.delete', $employee->user_id) }}">
                                                @csrf
                                                @method('delete')
                                                <x-buttons.danger-button>
                                                    {{ __('Remove') }}
                                                </x-buttons.danger-button>
                                            </form>
                                        @endif
                                    </x-tables.td>
                                </tr>
                            @empty
                            @endforelse
                        </x-tables.table>
                    </x-cards.body>
                </x-cards.card>

            </div>
        </div>
    </div>

</x-app-layout>
