<!-- Modals: With Form -->
<div x-data="{ open: @json($errors->any()) }" class="whitespace-normal">

    <!-- Placeholder -->
    <div>
        <!-- Modal Toggle Button -->
        <x-buttons.danger-button x-on:click="open = true; document.body.classList.add('overflow-hidden')" type="button">
            <svg class="hi-mini hi-trash inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                    clip-rule="evenodd" />
            </svg>
        </x-buttons.danger-button>
        <!-- END Modal Toggle Button -->
    </div>

    <!-- END Placeholder -->
    <form method="post" action="{{ route('warehouse.tenants.customer.contact.remove', $customer) }}">
        @csrf
        @method('delete')
        <!-- Modal Backdrop -->
        <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-bind:aria-hidden="!open" tabindex="-1" role="dialog"
            class="z-90 fixed inset-0 overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-75 backdrop-blur-sm p-4 lg:p-8">
            <!-- Modal Dialog -->
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-125" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-125" role="document"
                class="w-full max-w-md mx-auto flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="flex justify-between items-center py-4 px-5 bg-flash-white dark:bg-gray-700/50">
                    <div>
                        <h3 class="font-semibold mb-1">
                            Remove Contact
                        </h3>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Remove this contact from the customer
                        </h4>
                    </div>
                    <div class="-my-4">
                        <x-buttons.primary-button
                            x-on:click="open = false; document.body.classList.remove('overflow-hidden')" type="button">
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
                    <p>
                        This will remove any contact connections associated to this customer.
                    </p>
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                    <input type="hidden" name="contact_id" value="{{ $contact->id }}" />
                </div>
                <!-- Footer -->
                <div class="text-right space-x-1 py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <x-buttons.danger-button type="submit">
                        Remove Contact
                    </x-buttons.danger-button>
                    <x-buttons.secondary-button
                        x-on:click="open = false; document.body.classList.remove('overflow-hidden')" type="button">
                        Cancel
                    </x-buttons.secondary-button>
                </div>
            </div>
            <!-- END Modal Dialog -->
        </div>
        <!-- END Modal Backdrop -->
    </form>
</div>
<!-- END Modals: With Form -->
