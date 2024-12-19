<?php

namespace App\Modules\Admin\Translation;

use App\Traits\Livewire\WithTableNumbering;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;
use Spatie\TranslationLoader\LanguageLine;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    protected $model = LanguageLine::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            Column::make("Group", "group")
                ->sortable(),
            Column::make("Key", "key")
                ->sortable(),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update roles') ? [
                            'type' => 'wire',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => '$dispatch(\'modal-form\', {id: ' . $value . '})',
                        ] : null,
                        Gate::allows('delete roles') ? [
                            'type' => 'wire',
                            'label' => 'Delete',
                            'icon' => 'trash',
                            'action' => '$dispatch(\'delete-confirmation\', {id: ' . $value . '})',
                        ] : null,
                    ]),
                ]),
        ];
    }

    public function builder(): Builder
    {
        return LanguageLine::query()
            ->orderBy('id', 'desc');
    }
}
