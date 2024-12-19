<?php

namespace App\Modules\Admin\AuditLog;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Gate;
use App\Traits\Livewire\WithTableNumbering;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = AuditLog::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn()
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'actions' => array_filter([
                        Gate::allows('update users') ? [
                            'type' => 'link',
                            'label' => 'View',
                            'icon' => 'eye',
                            'action' => route('admin.audit-logs.view', $value),
                        ] : null,
                    ]),
                ]),
            Column::make("Action Type", "description")
                ->sortable()
                ->format(function ($value, $column, $row) {
                    $badge = [
                        'created' => 'bg-green-100 text-green-800',
                        'updated' => 'bg-blue-100 text-blue-800',
                        'deleted' => 'bg-red-100 text-red-800',
                    ];

                    return "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full {$badge[$value]}'>" . strtoupper($value) . "</span>";
                })
                ->html(),

            Column::make("Subject Type", "subject_type")
                ->sortable(),
            Column::make("Subject", "subject_id")
                ->sortable()
                ->format(function ($value, $column, $row) {
                    return $value;
                })
                ->html(),
            Column::make("User", "user.name")
                ->sortable(),
            Column::make("Host", "host"),
            Column::make("User Agent", "user_agent")
                ->format(function ($value, $column, $row) {
                    return strlen($value) > 25 ? substr($value, 0, 25) . '...' : $value;
                }),
            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return AuditLog::query()
            ->with('user')
            ->orderBy('created_at', 'desc');
    }
}
