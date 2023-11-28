<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'group inline-flex items-center justify-center space-x-2 rounded-md border font-semibold transition focus:outline-none focus:ring-2 border-gray-600 bg-gray-600 text-white disabled:opacity-40 disabled:bg-gray-600 disabled:border-gray-600 hover:border-gray-800 hover:bg-gray-800 hover:text-white focus:ring-gray-500 focus:ring-opacity-50 active:border-gray-600 active:bg-gray-600 p-2 text-sm leading-5 sm:px-3',
    ]) }}>
    {{ $slot }}
</button>
