{{-- Assuming $name, $useOptionsAsValue, and $options are passed to this component --}}
<select
    {{ $attributes->merge([
        'class' =>
            'mt-1 group w-full text-left flex justify-between items-center gap-2 border bg-white px-3 py-2 leading-6 rounded-lg border-gray-200 focus:outline-none focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-primary-500',
    ]) }}>
    {{ $slot }}
</select>
