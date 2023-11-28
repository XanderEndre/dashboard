<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'group inline-flex items-center justify-center space-x-2 rounded-md border font-semibold transition focus:outline-none focus:ring-2 border-red-600 bg-red-600 text-white disabled:opacity-40 disabled:bg-red-600 disabled:border-red-600 hover:border-red-800 hover:bg-red-800 hover:text-white focus:ring-red-500 focus:ring-opacity-50 active:border-red-600 active:bg-red-600 p-2 text-sm leading-5 sm:px-3',
    ]) }}>
    {{ $slot }}
</button>
