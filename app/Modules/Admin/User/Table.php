<?php

namespace App\Modules\Admin\User;

use App\Models\User;
use App\Traits\Livewire\WithTableNumbering;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setLoadingPlaceholderStatus(true);
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update users') ? [
                            'type' => 'link',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => route('admin.users.edit', $value),
                        ] : null,
                        Gate::allows('delete users') ? [
                            'type' => 'wire',
                            'label' => 'Delete',
                            'icon' => 'trash',
                            'action' => '$dispatch(\'delete-confirmation\', {id: "' . $value . '"})',
                        ] : null,
                    ]),
                ]),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Phone", "phone_number")
                ->sortable(),
            Column::make("Zip", "zip")
                ->sortable(),
            Column::make("Country", "country")
                ->sortable(),
            Column::make("Gender", "gender")
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => ucfirst($value)
                )->html(),
            DateColumn::make("Created at", "created_at")
                ->outputFormat('Y-m-d'),
        ];
    }

    public function builder(): Builder
    {
        return User::query()
            ->where('name', '!=', 'superadmin', 'and')
            ->orderBy('id', 'asc');
    }
}
