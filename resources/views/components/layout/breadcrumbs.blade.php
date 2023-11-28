<nav {{ $attributes->merge(['class' => 'mb-6']) }}>
    <div class="flex items-center justify-between">
        <ul class="flex space-x-2 text-slate-500">
            <li>
                <a href="/dashboard" class="text-primary-500">Dashboard</a>
            </li>

            @foreach ($links as $label => $link)
                <li class="select-none text-slate-400">
                    >
                </li>
                <li>
                    <a href="{{ $link }}" class="text-primary-500">
                        {{ $label }}
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
</nav>
