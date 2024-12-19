<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Translations']
        ]" />

        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Translations</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                @can('create translations')
                    <x-button wire:click="modalForm()">
                        ADD
                    </x-button>
                @endcan

            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.translation.table />
            </div>
        </div>
    </div>
    <x-ui-modal :title="$dataId ? 'Edit Translation' : 'Create Translation'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetModal()" size="3xl">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-ui-select.styled :options="[
                        ['label' => 'Admin', 'value' => 'admin'],
                        ['label' => 'Frontend', 'value' => 'frontend'],
                    ]" select="label:label|value:value" label="Group"
                        wire:model="group" />
                </div>
                <div>
                    <x-ui-input label="Key" wire:model="key" required />
                </div>
                @foreach (config('app.languages') as $langLocale => $langName)
                    <div>
                        <x-ui-textarea :label="strtoupper($langLocale)" wire:model="text.{{ $langLocale }}" required />
                    </div>
                @endforeach
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
