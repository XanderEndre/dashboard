<section>
    <x-cards.card>
        <x-cards.header :title="'Create a Warehouse'" :description="'Enter the details of your new warehouse'" />
        <x-cards.body>
            <form method="post" action="{{ route('warehouse.store') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <x-forms.input-label for="name" :value="__('Warehouse Name')" />
                    <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                        class="mt-1 block w-full" required autofocus />
                    <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-buttons.primary-button>{{ __('Create') }}</x-buttons.primary-button>
                </div>
            </form>
        </x-cards.body>
    </x-cards.card>

</section>
