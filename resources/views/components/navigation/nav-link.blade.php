@props(['route', 'label'])

@php
    $isCurrentPage = Route::currentRouteName() === $route;
@endphp

<a href="{{ route($route) }}"
    class="group flex items-center space-x-2 rounded-lg border border-transparent px-2.5 text-sm font-medium {{ $isCurrentPage ? 'bg-primary-50 text-gray-900 dark:bg-primary-700 dark:text-white' : 'text-gray-800 hover:bg-primary-50 hover:text-gray-900 dark:border-transparent dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white' }}">
    <span
        class="flex flex-none items-center {{ $isCurrentPage ? 'text-primary-500 dark:text-primary-200' : 'text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-200' }}">
        {{ $slot }} <!-- Slot for the icon -->
    </span>
    <span class="grow py-2">{{ $label }}</span>
</a>


{{-- @props(['route', 'icon', 'label'])

@php
$isCurrentPage = Route::currentRouteName() === $route;
@endphp

<a href="{{ route($route) }}"
   class="group flex items-center space-x-2 rounded-lg border border-transparent px-2.5 text-sm font-medium {{ $isCurrentPage ? 'bg-primary-50 text-gray-900 dark:bg-primary-700 dark:text-white' : 'text-gray-800 hover:bg-primary-50 hover:text-gray-900 dark:border-transparent dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white' }}">
    <span
        class="flex flex-none items-center {{ $isCurrentPage ? 'text-primary-500 dark:text-primary-200' : 'text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-200' }}">
        {!! $icon !!}
    </span>
    <span class="grow py-2">{{ $label }}</span>
</a> --}}
