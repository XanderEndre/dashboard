<x-cards.card>
    <x-cards.header :title="'Update Warehouse'" :description="'Update the details of your warehouse'" />
    <x-cards.body>
        <form method="post" action="{{ route('warehouse.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div>
                <x-forms.input-label for="name" :value="__('Warehouse Name')" />
                <x-forms.text-input id="name" name="name" type="text" :value="old('name', $warehouse->name)" class="block w-full mt-1"
                    required autofocus />
                <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="flex items-center gap-4">
                <x-buttons.primary-button>{{ __('Update') }}</x-buttons.primary-button>
            </div>
        </form>
    </x-cards.body>
</x-cards.card>
