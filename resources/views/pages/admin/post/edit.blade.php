<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.posts.index'), 'label' => 'Posts'],
            ['label' => 'Edit']
        ]" />

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mx-auto">
            <form wire:submit.prevent="save">
                <div class="py-4">
                    <img src="{{ $thumbnail_url }}" alt="preview" class="w-full max-w-sm bg-gray-100 border-dashed border border-gray-400 rounded-lg mx-auto aspect-video">
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 p-8">
                    <div>
                        <x-ui-upload label="Thumbnail" wire:model="thumbnail" />
                        <x-input-error for="thumbnail" class="mt-2" />
                    </div>
                    <div>
                        <x-ui-input label="Thumbnail Caption" wire:model="thumbnail_caption" :value="old('thumbnail_caption')" required />
                    </div>
                    <div>
                        <x-ui-select.styled
                            :options="$categories"
                            select="label:name|value:id"
                            label="Category"
                            wire:model="category_id"
                        />
                    </div>
                    <div>
                        <x-ui-select.styled
                            :options="[
                                ['label' => 'Draft', 'value' => 'draft'],
                                ['label' => 'Published', 'value' => 'published'],
                            ]"
                            select="label:label|value:value"
                            label="Status"
                            wire:model="status"
                        />
                    </div>
                </div>
                <x-ui-tab selected="EN">
                @foreach ($locales as $locale)
                <x-ui-tab.items tab="{{ strtoupper($locale) }}">
                    <div>
                        <x-ui-input label="Title" wire:model="datatranslations.{{ $locale }}.title" :value="old('title')" />
                    </div>
                    <div class="mt-5">
                        <x-label>Description</x-label>
                        <textarea
                            wire:model="datatranslations.{{ $locale }}.description"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-slate-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md sm:text-sm"
                            placeholder="['Option 1', 'Option 2']"
                            rows="5">
                        </textarea>
                    </div>
                    <div class="mt-5">
                        <x-editor
                            label="Content"
                            wire:model="datatranslations.{{ $locale }}.content"
                        />
                    </div>
                </x-ui-tab.items>
                @endforeach
                </x-ui-tab>
                <div class="flex justify-end mt-5 py-4 mr-8">
                    <x-ui-button text="SAVE" color="indigo" type="submit" class="font-semibold text-xs tracking-widest" />
                </div>
            </form>
        </div>
    </div>
    @push('styles')
        <style>
            .dark\:bg-dark-700.bg-white.rounded-lg.shadow-md {
                background-color: #ffffff !important;
                /* bg-white */
                background-color: #1f2937 !important;
                /* dark:bg-gray-800 */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
                /* shadow */
                border-radius: 0.5rem !important;
                /* rounded-lg */
                padding: 1.5rem !important;
                /* p-6 */
            }

            @media (prefers-color-scheme: dark) {
                .dark\:bg-dark-700.bg-white.rounded-lg.shadow-md {
                    background-color: #1f2937 !important;
                    /* dark:bg-gray-800 */
                }
            }
        </style>
    @endpush
</div>
