<?php

namespace App\Modules\Admin\ShortLink;

use App\Models\ShortLink;
use Illuminate\Support\Facades\Gate;
use App\Traits\Livewire\WithTableNumbering;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = ShortLink::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Url", "url")
                ->sortable(),
            Column::make("code", "code")
                ->format(fn($value, $row, Column $column) => '<button class="text-blue-500 no-underline hover:underline" onclick="navigator.clipboard.writeText(\'' . route('short-link', $value) . '\')">Copy</button>')
                ->html(),
            Column::make("Clicks", "clicks")
                ->sortable(),
            Column::make("Expires at", "expires_at")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update short-links') ? [
                            'type' => 'wire',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => '$dispatch(\'modal-form\', {id: "' . $value . '"})',
                        ] : null,
                        Gate::allows('delete short-links') ? [
                            'type' => 'wire',
                            'label' => 'Delete',
                            'icon' => 'trash',
                            'action' => '$dispatch(\'delete-confirmation\', {id: "' . $value . '"})',
                        ] : null,
                    ]),
                ]),
        ];
    }
}
