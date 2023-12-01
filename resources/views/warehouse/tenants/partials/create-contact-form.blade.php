<div x-data="{ filled: false }">
    <div class="grid grid-cols-12 gap-6">
        <!-- First Name -->
        <div class="sm:col-span-6 xs:col-span-12">
            <x-forms.input-label for="first_name" :value="__('First Name')" />
            <x-forms.text-input id="first_name" name="first_name" type="text"
                :value="old('first_name')" placeholder="e.g., John" class="block w-full mt-1" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('first_name')" x-bind:required="filled"
                @input="filled=true" />
        </div>

        <!-- Last Name -->
        <div class="sm:col-span-6 xs:col-span-12">
            <x-forms.input-label for="last_name" :value="__('Last Name')" />
            <x-forms.text-input id="last_name" name="last_name" type="text"
                :value="old('last_name')" placeholder="e.g., Doe" class="block w-full mt-1"
                x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('last_name')" x-bind:required="filled"
                @input="filled=true" />
        </div>


        <!-- Email -->
        <div class="sm:col-span-6 xs:col-span-3">
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" name="email" type="text" :value="old('email')"
                placeholder="e.g., john.doe@gmail.com" class="block w-full mt-1" x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')" x-bind:required="filled"
                @input="filled=true" />
        </div>

        <!-- Extension -->
        <div class="sm:col-span-2 xs:col-span-3">
            <x-forms.input-label for="extension" :value="__('Extension')" />
            <x-forms.text-input id="extension" name="extension" type="text"
                :value="old('extension')" placeholder="e.g., x1420" class="block w-full mt-1" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('extension')" x-bind:required="filled"
                @input="filled=true" />
        </div>

        <!-- Phone Number -->
        <div class="sm:col-span-4 xs:col-span-3">
            <x-forms.input-label for="phone_number" :value="__('Phone Number')" />
            <x-forms.text-input id="phone_number" name="phone_number" type="text"
                :value="old('phone_number')" placeholder="e.g., (123) 456-7890" class="block w-full mt-1"
                x-bind:required="filled" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('phone_number')" x-bind:required="filled"
                @input="filled=true" />
        </div>
    </div>
</div>