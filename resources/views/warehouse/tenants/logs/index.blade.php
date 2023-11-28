<x-app-layout>
    <div>
        <x-layout.breadcrumbs :links="['Warehouse' => '#']" pageTitle="Audit Logs" />

        <x-cards.card>
            <x-cards.header :title="'Warehouse Logs'" :description="'A list of all logs in this warehouse.'">

            </x-cards.header>
            <x-cards.body>
                @if ($logs->count() > 0)
                    <x-tables.table :headers="['User', 'Description', 'Time', 'Action']">
                        @foreach ($logs as $log)
                            <tr class="even:bg-gray-50 dark:even:bg-gray-900/50">
                                <x-tables.td>
                                    {{ $log->user->name }}
                                </x-tables.td>
                                <x-tables.td>
                                    {{ $log->description }}
                                </x-tables.td>


                                <x-tables.td>
                                    {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                </x-tables.td>
                                <x-tables.td>
                                    @if ($log->action == 'created')
                                        <x-badges.success>{{ $log->action }}</x-badges.success>
                                    @elseif ($log->action == 'updated')
                                        <x-badges.primary>{{ $log->action }}</x-badges.primary>
                                    @elseif ($log->action == 'deleted')
                                        <x-badges.danger>{{ $log->action }}</x-badges.danger>
                                    @else
                                        <x-badges.danger>Unknown Event</x-badges.danger>
                                    @endif

                                </x-tables.td>


                            </tr>
                        @endforeach

                    </x-tables.table>
                @endif
            </x-cards.body>
            <x-cards.footer>
                {{ $logs->links() }}
            </x-cards.footer>

        </x-cards.card>
    </div>
</x-app-layout>
