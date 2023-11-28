@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'w-full block border placeholder-gray-500 px-3 py-2 leading-6 rounded-lg border-gray-200 focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-primary-500 dark:placeholder-gray-400 dark:text-white',
]) !!} autocomplete="off" data-lpignore="true"
    data-form-type="other">
