<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Categories']
        ]" />
        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Categories</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                <x-button wire:click="modalForm()">
                    ADD
                </x-button>

            </div>
        </div>

        <!-- Table -->
        <div>
            <livewire:admin.category.Table />
        </div>
    </div>
    <x-ui-modal :title="$categoryId ? 'Edit Category' : 'Create Category'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetFields()" size="3xl">
        {{-- show all error --}}
        <x-ui-errors class="mb-2" />
        <form wire:submit.prevent="save" class="grid grid-cols-1 gap-5">
            <div>
                @if ($thumbnailUrl)
                <div class="flex justify-center items-center space-x-4">
                    <img
                        src="{{ $thumbnailUrl }}"
                        alt="Thumbnail Preview"
                        class="h-16 w-16 rounded-md shadow-md border border-gray-300"
                    />
                </div>
                @endif
                <x-ui-upload label="Thumbnail" wire:model="thumbnail" accept="image/*" />
            </div>
            <div>
                <x-ui-select.styled
                    :options="$parentCategories"
                    select="label:name|value:id"
                    label="Parent"
                    wire:model="parentId"
                    hint="Leave blank if this category is the main category"
                />
            </div>
            <x-ui-tab selected="EN">
                @foreach ($locales as $locale)
                    <x-ui-tab.items tab="{{ strtoupper($locale) }}">
                        <div class="mb-4">
                            <x-ui-input
                                :label="'Name (' . strtoupper($locale) . ')'" wire:model="datatranslations.{{ $locale }}.name"
                            />
                        </div>
                        <div>
                            <x-ui-textarea
                                :label="'Description (' . strtoupper($locale) . ')'"
                                wire:model="datatranslations.{{ $locale }}.description"
                                value=""
                            />
                        </div>
                    </x-ui-tab.items>
                @endforeach
            </x-ui-tab>
            <div>
                <x-ui-select.styled :options="[
                    ['label' => 'Draft', 'value' => 'draft'],
                    ['label' => 'Published', 'value' => 'published'],
                ]"
                    select="label:label|value:value"
                    label="Status"
                    wire:model="status"
                />
            </div>
            <div class="grid grid-cols-1 gap-5">
                {{-- <div>
                    <x-ui-select.styled
                        :options="array_map(fn($locale) => ['label' => strtoupper($locale), 'value' => $locale], $locales)"
                        label="Locale"
                        select="label:label|value:value"
                        wire:model.live="selectedLocale"
                        wire:change="$refresh"
                        required
                    />
                </div>
                <div>
                    <x-ui-select.native
                        :options="$parentCategories"
                        select="label:name|value:id"
                        label="Parent"
                        wire:model="parentId"
                        wire:key="parent-categories-{{ $selectedLocale }}"
                        hint="Leave blank if this category is the main category"
                    />

                </div>
                <div>
                    <x-ui-input
                        :label="'Name (' . strtoupper($selectedLocale) . ')'" wire:model="translations.{{ $selectedLocale }}.name"
                        required
                    />
                </div>
                <div>
                    <x-ui-textarea
                        :label="'Description (' . strtoupper($selectedLocale) . ')'"
                        wire:model="translations.{{ $selectedLocale }}.description"
                    />
                </div>
                <div>
                    <x-ui-select.styled :options="[
                        ['label' => 'Draft', 'value' => 'draft'],
                        ['label' => 'Published', 'value' => 'published'],
                        ['label' => 'Archived', 'value' => 'archived'],
                    ]"
                        select="label:label|value:value"
                        label="Status"
                        wire:model="status"
                    />
                </div> --}}
            </div>
            <div class="flex justify-end mt-5">
                <x-secondary-button wire:click="resetFields()" class="me-3" type="button" color="secondary">
                    CLOSE
                </x-secondary-button>
                <x-button type="submit" wire:loading.attr="disabled">
                    SAVE
                </x-button>
            </div>
        </form>
    </x-ui-modal>
</div>
