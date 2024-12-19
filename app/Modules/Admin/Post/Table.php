<?php

namespace App\Modules\Admin\Post;

use App\Models\Post;
use App\Models\User;
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

    protected $model = Post::class;

    public function mount()
    {
        $this->defaultLocaleSortColumn = app()->getLocale();
    }

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

            Column::make('Title', 'translation.title'),
            Column::make('Status', 'status')
                ->format(fn($value) => ucfirst($value)),
            Column::make('Category', 'category_id')
                ->format(
                    fn($value, $row) => $row->category
                        ? $row->category->getFormattedName($this->defaultLocaleSortColumn)
                        : '-'
                ),
            Column::make('Author', 'user_id')
                ->format(
                    fn($value, $row) => $row->user->name ?? '-'
                ),
            Column::make('Created At', 'created_at'),
            ViewComponentColumn::make('Action', 'id')
                ->component('components.table-action-column')
                ->attributes(fn($value, $row, Column $column) => [
                    'dropdown' => true,
                    'actions' => array_filter([
                        Gate::allows('update posts') ? [
                            'type' => 'link',
                            'label' => 'Edit',
                            'icon' => 'pencil-square',
                            'action' => route('admin.posts.edit', $value),
                        ] : null,
                        Gate::allows('delete posts') ? [
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
        return Post::query()
            ->with('user', 'translations', 'category.translations', 'category.parent.translations')
            ->orderBy('created_at', 'desc');
    }
}
