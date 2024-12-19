<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Settings']
        ]" />
        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Settings</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                @can('create settings')
                    <x-button wire:click="modalForm()">
                        ADD
                    </x-button>
                @endcan

            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.setting.table />
            </div>
        </div>
    </div>
    <x-ui-modal :title="$dataId ? 'Edit Role' : 'Create Role'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetModal()">
        <form wire:submit.prevent="save">
            {{-- <x-validation-errors class="mt-4" /> --}}

            <div class="space-y-4">
                <div>
                    <x-ui-select.styled :options="[
                        ['label' => 'General', 'value' => 'general'],
                        ['label' => 'Admin', 'value' => 'admin'],
                        ['label' => 'Frontend', 'value' => 'frontend'],
                    ]" select="label:label|value:value" label="Group"
                        wire:model.defer="group" />
                </div>
                <div>
                    <x-ui-select.styled :options="[
                        ['label' => 'Text', 'value' => 'text'],
                        ['label' => 'Number', 'value' => 'number'],
                        ['label' => 'Select', 'value' => 'select'],
                        ['label' => 'Image', 'value' => 'image'],
                        ['label' => 'File', 'value' => 'file'],
                        ['label' => 'Color', 'value' => 'color'],
                    ]" select="label:label|value:value" label="Type"
                        wire:model="type" />
                </div>
                <div>
                    <x-ui-input label="Key" type="text" wire:model.defer="key" required />
                </div>
                <div>
                    @if ($type === 'text')
                        <x-ui-input label="Value" type="text" wire:model.defer="value" />
                    @elseif ($type === 'image')
                        <x-ui-upload label="Image" wire:model.defer="fileUpload" accept="image/*" delete delete-method="deleting"  />
                        <img src="{{ asset('storage/' . $value) }}" alt="{{ $key }}" class="w-16 h-16">

                        <x-input-error for="fileUpload" class="mt-1" />
                    @elseif ($type === 'file')
                        <x-ui-upload label="File" wire:model.defer="fileUpload" accept="application/pdf" delete delete-method="deleting" />
                        <a href="{{ asset('storage/' . $value) }}" target="_blank" class="text-blue-500">Download File</a>

                        <x-input-error for="fileUpload" class="mt-1" />
                        {{-- @if ($fileUpload)
                            <p class="mt-2 text-sm">Preview: <img src="{{ $fileUpload->temporaryUrl() }}" class="h-16 w-16"></p>
                        @endif --}}
                    @elseif ($type === 'color')
                        <x-ui-color label="Color" wire:model.defer="value" />
                    @elseif ($type === 'number')
                        <x-ui-input label="Value" type="number" wire:model.defer="value" />
                    @elseif ($type === 'select')
                        @if ($attr)
                            @php
                                $options = json_decode($attr, true)['options'] ?? [];
                            @endphp
                            <x-ui-select.styled :options="$options" select="label:label|value:value" label="Value" wire:model.defer="value" />
                        @endif
                        <div class="mt-4">
                            {{-- <textarea label="Options (JSON)" type="text" wire:model.defer="attr" placeholder="['Option 1', 'Option 2']" /> --}}
                            <textarea id="attr"
                                wire:model.defer="attr"
                                wire:blur="formatJson"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md sm:text-sm"
                                placeholder="['Option 1', 'Option 2']"
                                rows="5">
                            </textarea>
                        </div>
                    @endif
                </div>
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
