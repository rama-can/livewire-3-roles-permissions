<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Permissions']
        ]" />
        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Permissions</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                @can('create permissions')
                    <x-button wire:click="modalForm()">
                        ADD
                    </x-button>
                @endcan

            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.permission.table />
            </div>
        </div>
    </div>
    <x-ui-modal :title="$dataId ? 'Edit Role' : 'Create Role'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetModal()">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-ui-input label="Name" wire:model="form.name" required />
                </div>
            </div>

            <div class="container mx-auto mt-5">
                <fieldset class="border border-lg rounded dark:ring-2 dark:ring-gray-400 grid grid-cols-2 col-span-2 mt-2">
                    <legend class="ml-2 px-3 bg-gray-700 font-extrabold">Roles</legend>

                    <div class="grid gap-y-4 py-4 grid-cols-2 col-span-2" >
                        @foreach($this->roles as $role)
                            <div wire:key="{{ $selectedPermission->id ?? '' }}-{{ $role->id }}" class="relative flex items-start pl-4 col-span-1 sm:col-span-1">
                                <div class="flex h-6 items-center">
                                    <input
                                        wire:model.live="form.roles"
                                        value="{{$role->name}}"
                                        type="checkbox"
                                        id="role-{{$role->id}}"
                                        class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600"
                                    >
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="role-{{$role->id}}" class="font-medium text-gray-900 dark:text-gray-100">{{ $role->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>

            <div class="flex justify-end mt-5">
                <x-secondary-button wire:click="resetModal()" class="me-3" type="button" color="secondary">
                    CLOSE
                </x-secondary-button>
                <x-button type="submit" wire:loading.attr="disabled">
                    SAVE
                </x-button>
            </div>
        </form>
    </x-ui-modal>
</div>
@push('scripts')
<script>
    window.addEventListener('livewire:load', () => {
        document.querySelector('input').focus()
    })
</script>
@endpush
