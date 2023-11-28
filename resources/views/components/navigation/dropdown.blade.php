@props(['label', 'submenuItems', 'dropdownName' => 'defaultDropdown'])

<div class="space-y-1" x-data="{ '{{ $dropdownName }}': false }">
    <button x-on:click.stop="{{ $dropdownName }} = !{{ $dropdownName }}" type="button"
        class="group flex w-full items-center space-x-2 rounded-lg border border-transparent px-2.5 text-left text-sm font-medium text-gray-800 hover:bg-primary-50 hover:text-gray-900 dark:border-transparent dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white">
        <!-- Icon Slot -->
        <span class="flex flex-none items-center text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-200">
            {{ $slot }}
        </span>
        <!-- Label -->
        <span class="grow py-2">{{ $label }}</span>
        <!-- Dropdown Icon -->
        <span class="flex-none opacity-75" x-bind:class="{ 'rotate-180': {{ $dropdownName }} }">
            <svg class="hi-mini hi-chevron-down inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </span>
        <!-- SVG for Chevron Down -->

    </button>

    <!-- Submenu Items -->
    <div x-cloak x-show="{{ $dropdownName }}" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="-translate-y-5 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-5 opacity-0" class="relative z-0 ml-7">
        @foreach ($submenuItems as $name => $route)
            <a href="{{ route($route) }}"
                class="flex items-center space-x-3 rounded px-3 text-sm font-medium text-gray-500 hover:text-gray-900 active:text-gray-500 dark:text-gray-400 dark:hover:text-gray-100 dark:active:text-gray-400">
                <span class="grow py-2">{{ $name }}</span>
            </a>
        @endforeach
    </div>
</div>
