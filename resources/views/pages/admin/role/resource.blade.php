<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Roles']
        ]" />
        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Roles</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add -->
                @can('create roles')
                    <x-button wire:click="modalForm()">
                        ADD
                    </x-button>
                @endcan

            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.role.table />
            </div>
        </div>
    </div>
    <x-ui-modal :title="$roleId ? 'Edit Role' : 'Create Role'" wire="isModalOpen" id="ui-modal" x-on:close="$wire.resetModal()">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-ui-input label="Name" wire:model="form.name" required />
                </div>
            </div>

            <div x-data="permissionsData({{ $this->permissions->toJson() }})" class="container mx-auto mt-5">
                <fieldset class="border border-lg rounded dark:ring-2 dark:ring-gray-400 p-4">
                    <legend class="ml-2 px-3 dark:bg-gray-700 font-extrabold">Permissions</legend>

                    <div class="flex justify-between items-center mb-4">
                        <x-ui-input x-model="search" placeholder="Cari permission..." />
                        <div>
                            <x-ui-button @click="selectAll" text="Select All" sm class="me-2" />
                            <x-ui-button @click="deselectAll" text="Deselect" sm color="red" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-4 scrollable-container">
                        @foreach ($this->permissions as $module => $modulePermissions)
                            <div x-show="hasVisiblePermissions('{{ $module }}')"
                                class="p-4 border rounded-lg bg-gray-100 dark:bg-gray-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ ucfirst($module) }}
                                </h3>

                                <div class="space-y-2 scrollable-inner">
                                    @foreach ($modulePermissions as $permission)
                                        <div class="flex items-center"
                                            x-show="filterPermission('{{ $permission->name }}')">
                                            <input type="checkbox" x-model="selectedPermissions"
                                                value="{{ $permission->name }}" id="permission-{{ $permission->id }}"
                                                class="permission-checkbox h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600">
                                            <label for="permission-{{ $permission->id }}"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
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
        function permissionsData(allPermissions) {
            return {
                search: '',
                selectedPermissions: @entangle('form.permissions'),
                allPermissions,

                filterPermission(permissionName) {
                    return permissionName.toLowerCase().includes(this.search.toLowerCase());
                },

                hasVisiblePermissions(module) {
                    return this.allPermissions[module].some(permission =>
                        this.filterPermission(permission.name)
                    );
                },

                selectAll() {
                    this.selectedPermissions = [];
                    Object.keys(this.allPermissions).forEach(module => {
                        this.allPermissions[module].forEach(permission => {
                            this.selectedPermissions.push(permission.name);
                        });
                    });
                },

                deselectAll() {
                    this.selectedPermissions = [];
                },
            };
        }

        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('permissionsData', () => ({
        //         search: '',
        //         selectedPermissions: @entangle('form.permissions'),

        //         // Filter permissions based on search input
        //         filterPermission(permissionName) {
        //             return permissionName.toLowerCase().includes(this.search.toLowerCase());
        //         },

        //         // Check if a module has at least one visible permission
        //         hasVisiblePermissions(module) {
        //             const permissions = @json($this->permissions);
        //             return permissions[module].some(permission =>
        //                 this.filterPermission(permission.name)
        //             );
        //         },

        //         // Select all permissions
        //         selectAll() {
        //             this.selectedPermissions = @json($this->permissions->flatMap(fn($modulePermissions) => $modulePermissions->pluck('name')));
        //         },

        //         // Deselect all permissions
        //         deselectAll() {
        //             this.selectedPermissions = [];
        //         }
        //     }));
        // });
    </script>
@endpush
@push('styles')
    <style>
        .scrollable-container {
            max-height: 24rem;
            overflow-y: auto;
        }

        .scrollable-inner {
            max-height: 10rem;
            overflow-y: auto;
        }
    </style>
@endpush
