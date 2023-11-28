<section>

    <form method="post" action="{{ route('warehouse.customer.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create a Customer'" :description="'Enter the details of your new customer'" />
            <x-cards.body>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Customer Name -->
                    <div>
                        <x-forms.input-label for="name" :value="__('Customer Name')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Payment Terms -->
                    <div>
                        <x-forms.input-label for="payment_terms" :value="__('Payment Terms')" required />
                        <x-forms.text-input id="payment_terms" name="payment_terms" type="text" :value="old('payment_terms')"
                            placeholder="e.g., ABC" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('payment_terms')" />
                    </div>
                </div>
            </x-cards.body>
        </x-cards.card>
        {{-- @if (count($customerOptions) > 0)
            <x-cards.card>
                <x-cards.header :title="'Parent Customer'" :description="'Select the parent of this customer'" />
                <x-cards.body>
                    <div x-data="{ choice: '{{ old('parent_customer_choice', null) }}' }">
                        <x-buttons.primary-button @click="choice = 'select'" type="button" class="w-full py-3">Select
                            Parent Customer</x-buttons.primary-button>

                        <input type="hidden" name="parent_customer_choice" x-bind:value="choice">

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_parent_id" :value="__('Select Parent Customer')" />
                                <x-forms.select name="selected_parent_id" :options="$customerOptions" class="mt-1"
                                    x-bind:required="choice === 'select'"></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_parent_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                </x-cards.body>
            </x-cards.card>
        @endif --}}
        {{-- <x-cards.card>
            <x-cards.header :title="'Customer Address'" :description="'Create or select the address for the customer'" />
            <x-cards.body>
                @if (count($addressOptions) > 0)
                    <div x-data="{ choice: '{{ old('address_choice', null) }}' }">
                        <div class="flex space-x-2">
                            <x-buttons.primary-button @click="choice = 'create'" type="button"
                                class="w-full py-3">Create
                                Address</x-buttons.primary-button>
                            <x-buttons.primary-button @click="choice = 'select'" type="button"
                                class="w-full py-3">Select
                                Address</x-buttons.primary-button>
                        </div>

                        <input type="hidden" name="address_choice" x-bind:value="choice">

                        <div x-show="choice === 'create'" class="mt-4">
                            <x-forms.address-input :old="old()" :errors="$errors" />
                        </div>

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_address_id" :value="__('Select Address')" />
                                <x-forms.select name="selected_address_id" :options="$addressOptions" class="mt-1"
                                    x-bind:required="choice === 'select'" /></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_address_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                @else
                    <x-forms.address-input :old="old()" :errors="$errors" />
                @endif
            </x-cards.body>
        </x-cards.card> --}}
        {{-- 
        <x-cards.card>
            <x-cards.header :title="'Customer Contact Information'" :description="'Create or select the contact information for the customer'" />
            <x-cards.body>
                @if (count($contactOptions) > 0)
                    <div x-data="{ choice: '{{ old('contact_choice', null) }}' }">
                        <div class="flex space-x-2">
                            <x-buttons.primary-button @click="choice = 'create'" type="button" class="w-full py-3">Create
                                Contact Information</x-buttons.primary-button>
                            <x-buttons.primary-button @click="choice = 'select'" type="button" class="w-full py-3">Select
                                Contact Information</x-buttons.primary-button>
                        </div>

                        <input type="hidden" name="contact_choice" x-bind:value="choice">


                        <div x-show="choice === 'create'" class="mt-4">
                            <div x-data="{ filled: false }">
                                <x-forms.contact-input :old="old()" :errors="$errors" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>

                        <div x-show="choice === 'select'" class="mt-2">
                            <div class="mt-4">
                                <x-forms.input-label for="selected_contact_id" :value="__('Select Contact')" />
                                <x-forms.select name="selected_contact_id" :options="$contactOptions" class="mt-1"
                                    x-bind:required="choice === 'select'"></x-forms.select>

                                <x-forms.input-error class="mt-2" :messages="$errors->get('selected_contact_id')" />
                                <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                    class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                            </div>
                        </div>
                    </div>
                @else
                    <x-forms.contact-input :old="old()" :errors="$errors" />
                @endif
            </x-cards.body>
        </x-cards.card> --}}


        <x-cards.card>
            <x-cards.header :title="'Create new Customer'" :description="'Create your new customer'" />
            <x-cards.body>
                <div class="flex items-center gap-4">
                    <x-buttons.primary-button type="submit"
                        class="w-full p-2">{{ __('CREATE') }}</x-buttons.primary-button>
                </div>
            </x-cards.body>
        </x-cards.card>
    </form>
</section>
