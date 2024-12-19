<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <input type="text" name="username" value="" autocomplete="username" style="display: none;">
            <x-ui-password label="Current Password" wire:model="state.current_password"
                autocomplete="current_password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-ui-password label="New Password" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-1" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-ui-password label="Confirm Password" wire:model="state.password_confirmation"
                autocomplete="password_confirmation" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
