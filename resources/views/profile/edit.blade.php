<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="space-y-6">
            <x-cards.card>
                <x-cards.header :title="'Profile Information'" :description="'Update your account\'s profile information and email address.'" />
                <x-cards.body>
                    @include('profile.partials.update-profile-information-form')
                </x-cards.body>
            </x-cards.card>

            <x-cards.card>
                <x-cards.header :title="'Update Password'" :description="'Ensure your account is using a long, random password to stay secure.'" />
                <x-cards.body>
                    @include('profile.partials.update-password-form')
                </x-cards.body>
            </x-cards.card>

            <x-cards.card>
                <x-cards.header :title="'Delete Account'" :description="'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'" />
                <x-cards.body>
                    @include('profile.partials.delete-user-form')
                </x-cards.body>
            </x-cards.card>


        </div>
    </div>
</x-app-layout>
