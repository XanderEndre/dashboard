@props(['title'])
<!-- Card Header -->
<div
    {{ $attributes->merge(['class' => 'py-4 px-5 bg-flash-white dark:bg-gray-700/50 flex items-center justify-between']) }}>
    <h3 class="font-semibold mb-1">
        {{ $title }}
    </h3>
    <div>
        {{ $slot }}
    </div>
</div>
<!-- END Card Header -->
