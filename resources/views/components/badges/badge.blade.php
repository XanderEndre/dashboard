@props(['state'])

@if ($state === 'Review')
    <span
        {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-600/20']) }}>
        {{ $state }}
    </span>
@elseif($state === 'Completed')
<span
        {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20']) }}>
        {{ $state }}
    </span>
@endif
