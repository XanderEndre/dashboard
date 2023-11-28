<x-cards.card>
    <x-cards.header :title="'Add an employee'" :description="'Enter the details of your new employee'" />
    <x-cards.body>
        <form method="post" action="{{ route('warehouse.employee.store') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-forms.input-label for="email" :value="__('Employee Email')" />
                <x-forms.text-input id="email" name="email" type="text" :value="old('email')" class="block w-full mt-1"
                    required autofocus />
                <x-forms.input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <div>
                    <x-forms.input-label for="role" :value="__('Employee Role')" />
                    <x-forms.select name="role" :options="array_combine(
                        array_map('ucfirst', \App\Models\Warehouse\WarehouseRoles::$applicableRoles),
                        \App\Models\Warehouse\WarehouseRoles::$applicableRoles,
                    )" :useOptionsAsValue="true"></x-forms.select>
                    <x-forms.input-error class="mt-2" :messages="$errors->get('role')" />

                </div>

            </div>

            <div class="flex items-center gap-4">
                <x-buttons.primary-button>{{ __('Add Employee') }}</x-buttons.primary-button>
            </div>
        </form>
    </x-cards.body>
</x-cards.card>
