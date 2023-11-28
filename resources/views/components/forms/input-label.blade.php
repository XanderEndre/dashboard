@props(['value'])
@props(['required' => true])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm dark:text-gray-100 text-gray-700']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500">
            *
        </span>
    @endif
</label>
