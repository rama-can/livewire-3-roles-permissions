<?php

namespace App\Modules\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Livewire\WithTableNumbering;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class Table extends DataTableComponent
{
    use WithTableNumbering;

    public string $defaultLocaleSortColumn;

    public function mount()
    {
        $this->defaultLocaleSortColumn = app()->getLocale();
    }

    protected $model = Category::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFiltersStatus(true);
    }

    public function columns(): array
    {
        return [
            $this->numberingColumn(),
            ImageColumn::make('Thumbnail')
                ->location(
                    fn($row) => $row->translations->first()?->thumbnail
                        ? asset('storage/' . $row->translations->first()->thumbnail)
                        : asset('images/placeholder-image.webp')
                )
                ->attributes(fn($row) => [
                    'alt' => $row->translations->first()?->name,
                    'class' => 'h-10 w-12 object-cover object-center',
                ]),

            Column::make('Name', 'translation.name')
                ->format(
                    fn($value, $row) => $value ?? '-'
                )
                ->searchable()
                ->sortable(),

            Column::make('Slug', 'translation.slug')
                ->format(
                    fn($value, $row) => $value ?? '-'
                )
                ->searchable()
                ->sortable(),

            Column::make('Parent', 'parent_id')
                ->format(
                    fn($value, $row) => $row->parent?->translations->firstWhere('locale', $this->defaultLocaleSortColumn)?->name ?? '-'
                ),
            Column::make('Status', 'translation.status')
                ->format(
                    fn($value, $row) => ucfirst($value) ?? '-'
                )
                ->sortable(),

            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update categories') ? [
                            'type' => 'wire',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => '$dispatch(\'modal-form\', {id: "' . $value . '"})',
                        ] : null,
                        Gate::allows('delete categories') ? [
                            'type' => 'wire',
                            'label' => 'Delete',
                            'icon' => 'trash',
                            'action' => '$dispatch(\'delete-confirmation\', {id: "' . $value . '"})',
                        ] : null,
                    ]),
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Locale')
                ->options([
                    'en' => 'EN',
                    'id' => 'ID'
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('locale', $value);
                    $this->defaultLocaleSortColumn = $value;
                })
                ->notResetByClearButton()
                ->hiddenFromPills()
                ->setFilterDefaultValue(app()->getLocale()),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Category::query()
            ->with(['parent.translations', 'children', 'translations'])
            ->orderBy('id', 'desc');
    }
}
