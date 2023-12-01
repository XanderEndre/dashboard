<!-- Modals: With Form -->
<div x-data="{ openAddress: @json($errors->any()) }">
    {{-- <div x-data="{ openAddress: false }"> --}}

    <!-- Placeholder -->
    <div>
        <!-- Modal Toggle Button -->
        <x-buttons.primary-button x-on:click="openAddress = true; document.body.classList.add('overflow-hidden')"
            type="button">
            Add Address
        </x-buttons.primary-button>
        <!-- END Modal Toggle Button -->
    </div>
    <!-- END Placeholder -->
    <form method="post" action="{{ $route }}">
        @csrf
        <!-- Modal Backdrop -->
        <div x-cloak x-show="openAddress" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-bind:aria-hidden="!openAddress" tabindex="-1" role="dialog"
            class="z-90 fixed inset-0 overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-75 backdrop-blur-sm p-4 lg:p-8">
            <!-- Modal Dialog -->
            <div x-cloak x-show="openAddress" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-125" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-125" role="document"
                class="w-full max-w-4xl mx-auto flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="flex justify-between items-center py-4 px-5 bg-flash-white dark:bg-gray-700/50">
                    <div>
                        <h3 class="font-semibold mb-1">
                            Create Address
                        </h3>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Create or select a new address for this {{ $title }}
                        </h4>
                    </div>
                    <div class="-my-4">
                        <x-buttons.primary-button
                            x-on:click="openAddress = false; document.body.classList.remove('overflow-hidden')"
                            type="button">
                            <svg class="hi-solid hi-x inline-block w-4 h-4 -mx-1" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </x-buttons.primary-button>
                    </div>
                </div>
                <!-- Body -->
                <div class="p-5 grow">



                    <div x-data="{ choice: '{{ old('address_choice', null) }}' }">

                        <div class="flex space-x-2">
                            <x-buttons.primary-button @click="choice = 'create'" type="button"
                                class="w-full py-3">Create
                                Address</x-buttons.primary-button>
                            @if (count($addressOptions) > 0)
                                <x-buttons.primary-button @click="choice = 'select'" type="button"
                                    class="w-full py-3">Select
                                    Address</x-buttons.primary-button>
                            @endif
                        </div>


                        <input type="hidden" name="address_choice" x-bind:value="choice">

                        <div x-show="choice === 'create'" class="mt-4">
                            @include('warehouse.tenants.partials.create-address-form')
                        </div>

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_address_id" :value="__('Select Address')" />
                                <x-forms.select name="selected_address_id" :options="$addressOptions" class="mt-1"
                                    x-bind:required="choice === 'select'" />

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_address_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="text-right space-x-1 py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <x-buttons.secondary-button
                        x-on:click="openAddress = false; document.body.classList.remove('overflow-hidden')"
                        type="button">
                        Cancel
                    </x-buttons.secondary-button>

                    <x-buttons.primary-button type="submit">
                        Create Address
                    </x-buttons.primary-button>

                </div>
            </div>
            <!-- END Modal Dialog -->
        </div>
        <!-- END Modal Backdrop -->
    </form>
</div>
<!-- END Modals: With Form -->
