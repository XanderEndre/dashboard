@props(['title', 'description'])

<!-- Card Header -->
<div
    {{ $attributes->merge(['class' => 'py-4 px-5 bg-flash-white dark:bg-gray-700/50 flex justify-between items-center']) }}>
    <div>
        <h3 class="font-semibold mb-1">
            {{ $title }}
        </h3>
        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ $description }}
        </h4>
    </div>
    <div>
        {{ $slot }}
    </div>
</div>
<!-- END Card Header -->
