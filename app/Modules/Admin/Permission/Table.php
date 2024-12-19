<?php

namespace App\Modules\Admin\Permission;

use App\Models\Permission;
use App\Traits\Livewire\WithTableNumbering;
use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = Permission::class;

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
            Column::make("Created at", "created_at")
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update permissions') ? [
                            'type' => 'wire',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => '$dispatch(\'modal-form\', {id: ' . $value . '})',
                        ] : null,
                        Gate::allows('delete permissions') ? [
                            'type' => 'wire',
                            'label' => 'Delete',
                            'icon' => 'trash',
                            'action' => '$dispatch(\'delete-confirmation\', {id: ' . $value . '})',
                        ] : null,
                    ]),
                ]),
        ];
    }
}
