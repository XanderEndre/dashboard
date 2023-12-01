<div x-data="{
    addressTypeFilled: false,
    addressFilled: false,
    addressTwoFilled: false,
    cityFilled: false,
    countryFilled: false,
    stateFilled: false,
    zipcodeFilled: false,
    phoneNumberFilled: false,
    emailFilled: false
}">
    <div class="grid grid-cols-4 gap-6">
        <!-- Address -->
        <div class="col-span-4">
            <x-forms.input-label for="address_type" :value="__('Address Type')" />
            <x-forms.select name="address_type" :options="\App\Models\Warehouse\Tenants\TenantAddressType::$addressType" class="mt-1" :useOptionsAsValue="true"
                x-bind:required="addressTypeFilled" @input="countryFilled = !!(event.target.value)" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('address_type')" />
        </div>

        <div class="col-span-4">
            <x-forms.input-label for="address" :value="__('Address')" />
            <x-forms.text-input id="address" name="address" type="text" :value="old('address')"
                placeholder="e.g., 1234 Main St" class="block w-full mt-1" x-bind:required="addressFilled"
                @input="addressFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Address 2 -->
        <div class="col-span-4">
            <x-forms.input-label for="address_two" :value="__('Address 2 (Optional)')" />
            <x-forms.text-input id="address_two" name="address_two" type="text" :value="old('address_two')"
                placeholder="e.g., Apartment or Suite" class="block w-full mt-1" x-bind:required="addressTwoFilled"
                @input="addressTwoFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('address_two')" />
        </div>

        <!-- City -->
        <div class="col-span-4">
            <x-forms.input-label for="city" :value="__('City')" />
            <x-forms.text-input id="city" name="city" type="text" :value="old('city')"
                placeholder="e.g., Las Vegas" class="block w-full mt-1" x-bind:required="cityFilled"
                @input="cityFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <!-- Country -->
        <div class="col-span-4 sm:col-span-2">
            <x-forms.input-label for="country" :value="__('Country')" />
            <x-forms.select name="country" :options="['United States']" class="mt-1" x-bind:required="countryFilled"
                @input="countryFilled = !!(event.target.value)">
                <!-- Country options here -->
            </x-forms.select>
            <x-forms.input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <!-- State -->
        <div class="sm:col-span-1 col-span-4">
            <x-forms.input-label for="state" :value="__('State')" />
            <x-forms.select name="state" :options="['Nevada', 'Utah', 'California']" class="mt-1" x-bind:required="stateFilled"
                @input="stateFilled = !!(event.target.value)">
                <!-- State options here -->
            </x-forms.select>
            <x-forms.input-error class="mt-2" :messages="$errors->get('state')" />
        </div>

        <!-- Zipcode -->
        <div class="sm:col-span-1 col-span-4">
            <x-forms.input-label for="zipcode" :value="__('ZIP Code')" />
            <x-forms.text-input id="zipcode" name="zipcode" type="text" :value="old('zipcode')"
                placeholder="e.g., 89052" class="block w-full mt-1" x-bind:required="zipcodeFilled"
                @input="zipcodeFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('zipcode')" />
        </div>

        <!-- Zipcode -->
        <div class="col-span-4 sm:col-span-2">
            <x-forms.input-label for="phone_number" :value="__('Phone Number')" />
            <x-forms.text-input id="phone_number" name="phone_number" type="text" :value="old('phone_number')"
                placeholder="e.g., 89052" class="block w-full mt-1" x-bind:required="phoneNumberFilled"
                @input="phoneNumberFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>
        <!-- Zipcode -->
        <div class="col-span-4 sm:col-span-2">
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" name="email" type="text" :value="old('email')"
                placeholder="e.g., 89052" class="block w-full mt-1" x-bind:required="emailFilled"
                @input="emailFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
    </div>
</div>
