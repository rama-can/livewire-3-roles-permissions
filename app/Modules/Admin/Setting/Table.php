<?php

namespace App\Modules\Admin\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\Gate;
use App\Traits\Livewire\WithTableNumbering;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = Setting::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            Column::make("key", "key")
                ->sortable(),
            Column::make("value", "value")
                // format value by type
                ->format(fn($value, $row, Column $column) => match ($row->type) {
                    'image' => '<img src="' . asset('storage/' . $value) . '" class="h-8 w-8 object-cover object-center" alt="">',
                    'file' => '<a href="' . asset('storage/' . $value) . '" class="text-blue-500 hover:underline" target="_blank">Download</a>',
                    default => $value,
                })
                ->html(),
            Column::make("type", "type")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update settings') ? [
                            'type' => 'wire',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => '$dispatch(\'modal-form\', {id: "' . $value . '"})',
                        ] : null,
                        // Gate::allows('delete settings') ? [
                        //     'type' => 'wire',
                        //     'label' => 'Delete',
                        //     'icon' => 'trash',
                        //     'action' => '$dispatch(\'delete-confirmation\', {id: ' . $value . '})',
                        // ] : null,
                    ]),
                ]),
        ];
    }
}
