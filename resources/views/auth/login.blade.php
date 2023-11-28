<x-guest-layout>


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
        <div class="p-4 md:px-16 md:py-12 grow">
            <h2 class="text-md text-center font-medium mb-5">
                Sign in to access your Warehouse
            </h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1">
                    <x-forms.input-label for="email" :value="__('Email')" />
                    <x-forms.text-input id="email" class="block w-full mt-1" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
                    <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <x-forms.input-label for="password" :value="__('Password')" />

                    <x-forms.text-input id="password" class="block w-full mt-1" type="password" name="password" required
                        autocomplete="current-password" placeholder="Enter your password" />

                    <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div>
                    <div class="flex items-center justify-between space-x-2">
                        <label class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember_me"
                                class="border border-gray-200 rounded h-4 w-4 text-blue-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:ring-offset-gray-900 dark:focus:border-blue-500 dark:checked:bg-blue-500 dark:checked:border-transparent">
                            <span class="text-sm ml-2">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}">Forgot
                            Password?</a>
                    </div>
                </div>

                <button type="submit"
                    class="w-full inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-6 py-3 leading-6 border-blue-700 bg-blue-700 text-white hover:text-white hover:bg-blue-600 hover:border-blue-600 focus:ring focus:ring-blue-400 focus:ring-opacity-50 active:bg-blue-700 active:border-blue-700 dark:focus:ring-blue-400 dark:focus:ring-opacity-90">
                    <svg class="hi-mini hi-arrow-uturn-right inline-block w-5 h-5 opacity-50"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.207 2.232a.75.75 0 00.025 1.06l4.146 3.958H6.375a5.375 5.375 0 000 10.75H9.25a.75.75 0 000-1.5H6.375a3.875 3.875 0 010-7.75h10.003l-4.146 3.957a.75.75 0 001.036 1.085l5.5-5.25a.75.75 0 000-1.085l-5.5-5.25a.75.75 0 00-1.06.025z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Sign In</span>
                </button>
            </form>
        </div>
        <div class="p-5 md:px-16 grow text-sm text-center bg-flash-white dark:bg-gray-700/50">
            Don’t have an account yet?
            <a href="{{ route('register') }}">Register
                today</a>
        </div>
    </div>

</x-guest-layout>
