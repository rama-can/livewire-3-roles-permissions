<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.users.index'), 'label' => 'Users'],
            ['label' => 'Create']
        ]" />

        <!-- form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <x-validation-errors class="mt-4" />

            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <x-ui-upload label="Photos" wire:model="image" />
                        <x-input-error for="image" class="mt-2" />
                    </div>
                    <div>
                        <x-ui-input label="Name" id="name" type="text" wire:model="name" :value="old('name')"
                            required />
                    </div>
                    <div>
                        <x-ui-input label="Username" id="username" type="text" wire:model="username"
                            :value="old('username')" required />
                    </div>
                    <div>
                        <x-ui-input label="Email" id="email" type="email" wire:model="email" :value="old('email')"
                            required />
                    </div>
                    <div>
                        <x-ui-password label="Password" id="password" wire:model="password" :value="old('password')" />
                    </div>
                    <div>
                        <x-ui-number label="Phone Number" id="phone_number" type="text" wire:model="phone_number"
                            :value="old('phone_number')" />
                    </div>
                    <div>
                        <x-ui-date label="Date of Birth" :max-date="now()" :min-year="1960" :max-year="now()->year"
                            wire:model="dob" />
                    </div>
                    <div>
                        <x-ui-select.styled label="Country" :request="[
                            'url' => route('country'),
                            'method' => 'get',
                            'params' => ['library' => 'TallStackUi'],
                        ]" select="label:name|value:code"
                            wire:model="country" />
                    </div>
                    <div>
                        <x-ui-select.styled label="Role" :options="$this->roles" select="label:name|value:id"
                            wire:model="role" />
                    </div>
                </div>
                <div class="flex justify-end mt-5">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">Create
                        User</button>
                </div>
            </form>
        </div>
    </div>
</div>
