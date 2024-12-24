<?php

namespace App\Modules\Admin\Subscription;

use App\Models\Subscriber as Subscription;
use Illuminate\Support\Facades\Gate;
use App\Traits\Livewire\WithTableNumbering;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = Subscription::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Subcribe at", "created_at")
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('delete subscriptions') ? [
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
