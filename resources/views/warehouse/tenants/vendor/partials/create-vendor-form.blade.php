<section>

    <form method="post" action="{{ route('warehouse.tenants.vendor.store') }}">
        @csrf
        <x-cards.card>
            <x-cards.header :title="'Create a Vendor'" :description="'Enter the details of your new vendor'" />
            <x-cards.body>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Vendor Name -->
                    <div>
                        <x-forms.input-label for="name" :value="__('Vendor Name')" required />
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                            placeholder="e.g., ABC Suppliers" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Vendor Short Name -->
                    <div>
                        <x-forms.input-label for="short_name" :value="__('Vendor Short Name')" required />
                        <x-forms.text-input id="short_name" name="short_name" type="text"
                            :value="old('short_name')" placeholder="e.g., ABC" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('short_name')" />
                    </div>

                    <!-- Vendor Phone Number -->
                    <div>
                        <x-forms.input-label for="phone_number" :value="__('Vendor Phone Number')" required />
                        <x-forms.text-input id="phone_number" name="phone_number" type="text" :value="old('phone_number')"
                            placeholder="e.g., +1 (123) 456-7890" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('phone_number')" />
                    </div>

                    <!-- Vendor Payment Terms -->
                    <div>
                        <x-forms.input-label for="payment_terms" :value="__('Vendor Payment Terms')" required />
                        <x-forms.text-input id="payment_terms" name="payment_terms" type="text" :value="old('payment_terms')"
                            placeholder="e.g., Net 30" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('payment_terms')" />
                    </div>

                    <!-- Vendor Account Number -->
                    <div>
                        <x-forms.input-label for="account_number" :value="__('Vendor Account Number')" required />
                        <x-forms.text-input id="account_number" name="account_number" type="text" :value="old('account_number')"
                            placeholder="e.g., 12345678" class="block w-full mt-1" required />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('account_number')" />
                    </div>
                </div>
            </x-cards.body>
        </x-cards.card>

        {{-- 
        <!-- Address Selector -->
        <div class="mb-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <header class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ __('Vendor Address') }} <span class="text-gray-600 text-sm">(optional)</span>
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Create or select the address for the vendor') }}
                    </p>
                </header>
                <div>

                    <!-- Check if there are existing addresses -->
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
                                        x-bind:required="choice === 'select'"></x-forms.select>

                                    <x-forms.input-error class="mt-2" :messages="$errors->get('selected_address_id')" />
                                    <x-buttons.primary-button @click="choice = 'cancel'" type="button"
                                        class="w-full py-3 mt-3">Cancel</x-buttons.primary-button>
                                </div>
                            </div>
                        </div>
                    @else
                        <x-forms.address-input :old="old()" :errors="$errors" />
                    @endif

                </div>
            </div>
        </div>

        <!-- Vendor Contact Selector -->
        <x-cards.card>
            <header class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ __('Vendor Contact Information') }} <span class="text-gray-600 text-sm">(optional)</span>
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Create or select the contact information for the vendor') }}
                </p>
            </header>
            <div>

                <!-- Check if there are existing contacts -->
                @if (count($contactOptions) > 0)
                    <div x-data="{ choice: '{{ old('contact_choice', null) }}' }">
                        <div class="flex space-x-2">
                            <x-buttons.primary-button @click="choice = 'create'" type="button"
                                class="w-full py-3">Create
                                Contact Information</x-buttons.primary-button>
                            <x-buttons.primary-button @click="choice = 'select'" type="button"
                                class="w-full py-3">Select
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

            </div>
        </x-cards.card> --}}


        <x-cards.card>
            <x-cards.body>

                <x-buttons.primary-button type="submit"
                    class="w-full p-2">{{ __('Create Vendor') }}</x-buttons.primary-button>

            </x-cards.body>
        </x-cards.card>
    </form>
</section>
