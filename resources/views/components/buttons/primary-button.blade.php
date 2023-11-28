<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'group inline-flex items-center justify-center space-x-2 rounded-md border font-semibold transition focus:outline-none focus:ring-2 border-primary-600 bg-primary-600 text-white disabled:opacity-40 disabled:bg-primary-600 disabled:border-primary-600 hover:border-primary-800 hover:bg-primary-800 hover:text-white focus:ring-primary-500 focus:ring-opacity-50 active:border-primary-600 active:bg-primary-600 p-2 text-sm leading-5 sm:px-3',
    ]) }}>
    {{ $slot }}
</button>
