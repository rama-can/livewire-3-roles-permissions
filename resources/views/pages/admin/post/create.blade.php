<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.posts.index'), 'label' => 'Posts'],
            ['label' => 'Create']
        ]" />

        <div class="bg-white dark:bg-gray-800 max-w-4xl mx-auto p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="save">
                {{-- mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl --}}
                {{-- <div class="max-w-4xl mx-auto p-6 rounded-lg shadow-md"> --}}
                {{-- <div class="grid grid-cols-2 gap-6"> --}}
                    <div>
                        <x-ui-input label="Title" wire:model="title" :value="old('title')" required />
                    </div>
                    <div class="mt-5 flex items-center space-x-4">
                        <div class="flex-1">
                            <x-ui-upload label="Thumbnail" wire:model="thumbnail" />
                            <x-input-error for="thumbnail" class="mt-2" />
                        </div>
                        <div class="flex-1">
                            <x-ui-input label="Thumbnail Caption" wire:model="thumbnail_caption" :value="old('thumbnail_caption')" required />
                        </div>
                    </div>
                    <div class="mt-5 flex items-center space-x-4">
                        <div class="flex-1">
                            <x-ui-select.styled
                                :options="$categories"
                                select="label:name|value:id"
                                label="Category"
                                wire:model="category_id"
                            />
                        </div>
                        <div class="flex-1">
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
                    <div class="mt-5">
                        <x-ui-textarea wire:model="description" label="Description" />
                    </div>
                    <div class="mb-5">
                        <x-editor
                                label="Content"
                                wire:model="content"
                            />
                        {{-- <x-editor model="content" label="Deskripsi" /> --}}
                    </div>
                {{-- </div> --}}
                <div class="flex justify-end mt-5 py-4 mr-8">
                    <x-ui-button text="SAVE" color="indigo" type="submit" class="font-semibold text-xs tracking-widest" />
                </div>
            </form>
        </div>
    </div>
</div>
