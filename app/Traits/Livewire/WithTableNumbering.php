<?php

namespace App\Traits\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithTableNumbering
{
    protected int $index = 0;

    public function numberingColumn(): Column
    {
        return Column::make(__('No.'))
            ->label(function () {
                $this->initializeIndex();
                return ++$this->index;
            });
    }

    protected function initializeIndex(): void
    {
        if ($this->index === 0) {
            $this->index = $this->getPage() > 1 ? ($this->getPage() - 1) * $this->perPage : 0;
        }
    }
}
