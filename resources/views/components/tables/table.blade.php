{{-- resources/views/components/table.blade.php --}}
<div class="border border-gray-200 rounded overflow-x-auto min-w-full bg-white dark:bg-gray-800 dark:border-gray-700">
    <table class="min-w-full text-sm align-middle whitespace-nowrap">
        <thead>
            <tr>
                @foreach ($headers as $header)
                    @if ($header == 'Actions')
                        <th
                            class="px-3 py-4 text-right text-gray-900 bg-gray-100/75 font-semibold dark:text-gray-50 dark:bg-gray-700/25">
                            {{ $header }}
                        </th>
                    @else
                        <th
                            class="px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-left dark:text-gray-50 dark:bg-gray-700/25">
                            {{ $header }}
                        </th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
