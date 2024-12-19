<!-- resources/views/components/table-action-column.blade.php -->
@if ($dropdown ?? false)
    <x-ui-dropdown icon="ellipsis-vertical">
        <x-slot:header>
            <p>Action</p>
        </x-slot:header>
        @foreach ($actions as $action)
            @if ($action['type'] === 'wire')
                <button class="flex w-full" type="button" wire:click="{{ $action['action'] }}">
                    <x-ui-dropdown.items :icon="$action['icon']" :text="$action['label'] ?? ''" separator />
                </button>
            @elseif ($action['type'] === 'link')
                <a href="{{ $action['action'] }}" class="flex w-full"
                    @if (!empty($action['blank'])) target="_blank"
                rel="noopener noreferrer" @else wire:navigate @endif>
                    <x-ui-dropdown.items :icon="$action['icon']" :text="$action['label']" separator />
                </a>
            @endif
        @endforeach
    </x-ui-dropdown>
@else
    <div class="flex space-x-2">
        @foreach ($actions as $action)
            @if ($action['type'] === 'wire')
                <!-- Tombol livewire -->
                <x-ui-button type="button" wire:click="{{ $action['action'] }}" :color="$action['color'] ?? 'indigo'" sm>
                    @if (!empty($action['icon']))
                        <x-ui-icon :name="$action['icon']" class="h-4 w-4" />
                    @endif
                    @if (!empty($action['label']))
                        <span class="font-semibold">{{ $action['label'] }}</span>
                    @endif
                </x-ui-button>
            @elseif ($action['type'] === 'link')
                <!-- Tombol Link -->
                <a href="{{ $action['action'] }}"
                    class="flex items-center px-2 py-0.5 text-white bg-slate-500 hover:bg-slate-700 rounded font-semibold text-sm"
                    @if (!empty($action['blank'])) target="_blank"
                    rel="noopener noreferrer" @endif>
                    @if (!empty($action['icon']))
                        <x-ui-icon :name="$action['icon']" class="h-5 w-5" />
                    @endif
                    @if (!empty($action['label']))
                        <span class="ml-1">{{ $action['label'] }}</span>
                    @endif
                </a>
            @endif
        @endforeach
    </div>
@endif
