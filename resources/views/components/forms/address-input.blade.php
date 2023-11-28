<div x-data="{
    addressFilled: false,
    addressTwoFilled: false,
    cityFilled: false,
    countryFilled: false,
    stateFilled: false,
    zipcodeFilled: false
}">
    <div class="grid grid-cols-3 gap-6">
        <!-- Address -->
        <div class="sm:col-span-3 xs:col-span-3">
            <x-forms.input-label for="address" :value="__('Address')" />
            <x-forms.text-input id="address" name="address" type="text" :value="old('address')"
                          placeholder="e.g., 1234 Main St" class="block w-full mt-1"
                          x-bind:required="addressFilled" @input="addressFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Address 2 -->
        <div class="sm:col-span-3 xs:col-span-3">
            <x-forms.input-label for="address_two" :value="__('Address 2 (Optional)')" />
            <x-forms.text-input id="address_two" name="address_two" type="text" :value="old('address_two')"
                          placeholder="e.g., Apartment or Suite" class="block w-full mt-1"
                          x-bind:required="addressTwoFilled" @input="addressTwoFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('address_two')" />
        </div>

        <!-- City -->
        <div class="sm:col-span-3 xs:col-span-3">
            <x-forms.input-label for="city" :value="__('City')" />
            <x-forms.text-input id="city" name="city" type="text" :value="old('city')"
                          placeholder="e.g., Las Vegas" class="block w-full mt-1"
                          x-bind:required="cityFilled" @input="cityFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <!-- Country -->
        <div class="sm:col-span-1 xs:col-span-3">
            <x-forms.input-label for="country" :value="__('Country')" />
            <x-forms.select name="country" :options="['United States']" class="mt-1"
                      x-bind:required="countryFilled" @input="countryFilled = !!(event.target.value)">
                <!-- Country options here -->
            </x-forms.select>
            <x-forms.input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <!-- State -->
        <div class="sm:col-span-1 xs:col-span-3">
            <x-forms.input-label for="state" :value="__('State')" />
            <x-forms.select name="state" :options="['Nevada', 'Utah', 'California']" class="mt-1"
                      x-bind:required="stateFilled" @input="stateFilled = !!(event.target.value)">
                <!-- State options here -->
            </x-forms.select>
            <x-forms.input-error class="mt-2" :messages="$errors->get('state')" />
        </div>

        <!-- Zipcode -->
        <div class="sm:col-span-1 xs:col-span-3">
            <x-forms.input-label for="zipcode" :value="__('ZIP Code')" />
            <x-forms.text-input id="zipcode" name="zipcode" type="text" :value="old('zipcode')"
                          placeholder="e.g., 89052" class="block w-full mt-1"
                          x-bind:required="zipcodeFilled" @input="zipcodeFilled = !!$event.target.value.trim()" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('zipcode')" />
        </div>
    </div>
</div>
