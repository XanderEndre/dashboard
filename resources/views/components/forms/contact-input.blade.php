<div x-data="{ filled: false }">
    <div class="grid grid-cols-12 gap-6">
        <!-- First Name -->
        <div class="sm:col-span-6 xs:col-span-12">
            <x-forms.input-label for="contact_first_name" :value="__('First Name')" />
            <x-forms.text-input id="contact_first_name" name="contact_first_name" type="text" :value="old('contact_first_name')"
                placeholder="e.g., John" class="block w-full mt-1" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_first_name')" x-bind:required="filled" @input="filled=true" />
        </div>

        <!-- Last Name -->
        <div class="sm:col-span-6 xs:col-span-12">
            <x-forms.input-label for="contact_last_name" :value="__('Last Name')" />
            <x-forms.text-input id="contact_last_name" name="contact_last_name" type="text" :value="old('contact_last_name')"
                placeholder="e.g., Doe" class="block w-full mt-1" x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_last_name')" x-bind:required="filled" @input="filled=true" />
        </div>


        <!-- Email -->
        <div class="sm:col-span-6 xs:col-span-3">
            <x-forms.input-label for="contact_email" :value="__('Email')" />
            <x-forms.text-input id="contact_email" name="contact_email" type="text" :value="old('contact_email')"
                placeholder="e.g., john.doe@gmail.com" class="block w-full mt-1" x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_email')" x-bind:required="filled" @input="filled=true" />
        </div>

        <!-- Extension -->
        <div class="sm:col-span-2 xs:col-span-3">
            <x-forms.input-label for="contact_extension" :value="__('Extension')" />
            <x-forms.text-input id="contact_extension" name="contact_extension" type="text" :value="old('contact_extension')"
                placeholder="e.g., x1420" class="block w-full mt-1" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_extension')" x-bind:required="filled" @input="filled=true" />
        </div>

        <!-- Phone Number -->
        <div class="sm:col-span-4 xs:col-span-3">
            <x-forms.input-label for="contact_phone_number" :value="__('Phone Number')" />
            <x-forms.text-input id="contact_phone_number" name="contact_phone_number" type="text" :value="old('contact_phone_number')"
                placeholder="e.g., (123) 456-7890" class="block w-full mt-1" x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_phone_number')" x-bind:required="filled" @input="filled=true" />
        </div>
    </div>
</div>
