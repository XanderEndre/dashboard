@props(['label'])

<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <!-- Trigger for Dropdown -->
    <button @click="open = !open"
        class="flex items-center space-x-2 rounded-lg px-2.5 py-2 text-sm font-medium text-gray-800 hover:bg-blue-50 hover:text-gray-900 dark:border-transparent dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white">
        <span>{{ $label }}</span>
        <!-- Icon indicating dropdown, rotated when open -->
        <svg :class="{ 'transform rotate-180': open }" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1">
            {{ $slot }} <!-- Slot for dropdown links -->
        </div>
    </div>
</div>
