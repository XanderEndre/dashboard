<!-- resources/views/components/dashboard-card.blade.php -->

@props(['number', 'label', 'description'])

<a href="javascript:void(0)"
    class="flex flex-col shadow-sm rounded-lg border bg-white text-black hover:text-black hover:border-gray-300 active:border-primary-300 dark:text-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:border-gray-600 dark:active:border-primary-700">
    <div class="p-5 grow flex justify-between items-center">
        <dl>
            <dt class="text-2xl font-bold">
                {{ $number }}
            </dt>
            <dd class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $label }}
            </dd>
        </dl>
        <div
            class="flex justify-center items-center rounded-xl w-12 h-12 text-primary-500 bg-primary-50 border border-primary-100 dark:text-primary-100 dark:bg-primary-900 dark:bg-opacity-25 dark:border-primary-900">
            {{ $slot }}
        </div>
    </div>
    <div
        class="py-3 px-5 text-xs font-medium text-gray-500 border-t border-gray-100 dark:text-gray-400 dark:border-gray-700/50">
        <p>
            {{ $description }}
        </p>
    </div>
</a>
