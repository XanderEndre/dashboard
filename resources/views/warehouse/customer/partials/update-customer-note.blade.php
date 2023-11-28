<x-cards.body>
    <!-- Alerts: Warning -->
    <div
        class="p-2 md:p-3 rounded text-gray-700 bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:bg-opacity-75 mb-4 ">
        <div class="flex items-center">
            <svg class="hi-solid hi-exclamation inline-block w-5 h-5 mr-3 flex-none text-gray-500 dark:text-gray-400"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <h3 class="font-semibold grow">
                The customer does not see these notes
            </h3>

        </div>
    </div>

    <!-- Form Elements: Textarea -->
    <form method="POST">
        @csrf
        @method('patch')
        <!-- Textarea -->
        <div class="space-y-1">
            <textarea id="customer_notes" :value="old('customer_notes', $customer->notes)" name="customer_notes" rows="4"
                placeholder="Enter further details"
                class="w-full block border placeholder-gray-500 px-5 py-3 leading-6 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-blue-500 dark:placeholder-gray-400"></textarea>
            <x-forms.input-error class="mt-2" :messages="$errors->get('customer_notes')" />

        </div>
        <!-- END Textarea -->
    </form>

    <!-- END Form Elements: Textarea -->
</x-cards.body>

<x-cards.footer>
    <x-buttons.primary-button>Save Note</x-buttons.primary-button>
</x-cards.footer>
