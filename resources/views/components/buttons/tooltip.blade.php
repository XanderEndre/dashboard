@props(['tooltip', 'position'])

<div class="group inline-block relative">
    <div>
        {{ $slot }}
    </div>
    @if ($position == 'top')
        <div
            class="invisible absolute left-1/2 -ml-20 w-40 will-change-auto bottom-full pb-2 z-1 translate-y-2 duration-50 origin-bottom scale-75 flex flex-col justify-center items-center opacity-75 transition ease-out group-hover:visible group-hover:scale-100 group-hover:translate-y-0 group-hover:opacity-100">
            <div
                class="flex-none rounded-lg px-2.5 py-2 text-xs font-semibold bg-gray-800 text-gray-50 dark:bg-gray-700 text-center">
                {{ $tooltip }}
            </div>
        </div>
    @elseif($position == 'left')
        <div
            class="invisible absolute top-0 bottom-0 right-full will-change-auto pr-2 z-1 translate-x-2 duration-50 origin-right scale-75 flex justify-end items-center opacity-75 transition ease-out group-hover:visible group-hover:scale-100 group-hover:translate-x-0 group-hover:opacity-100">
            <div
                class="flex-none rounded-lg px-2.5 py-2 text-xs whitespace-nowrap font-semibold bg-gray-800 text-gray-50 dark:bg-gray-700 text-center">
                {{ $tooltip }}
            </div>
        </div>
    @endif
</div>
