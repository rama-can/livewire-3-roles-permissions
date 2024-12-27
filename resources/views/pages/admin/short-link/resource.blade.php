<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Short Link'],
        ]" />

        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Short Links</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                @can('create short-links')
                    <x-button wire:click="modalForm()">
                        ADD
                    </x-button>
                @endcan

            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.ShortLink.table />
            </div>
        </div>
    </div>
    <x-ui-modal :title="$dataId ? 'Edit Short Link' : 'Short Link'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetModal()" size="xl">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-ui-input label="Name" wire:model="name" required />
                </div>
                <div>
                    <x-ui-input label="Url" wire:model="url" required />
                </div>
                <div>
                    <x-ui-date format="YYYY-MM-DD" :min-date="now()" label="Expires At" wire:model="expires_at" />
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
