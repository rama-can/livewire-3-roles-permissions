<?php

namespace App\Modules\Frontend\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class Index extends Component
{
    #[Computed()]
    public function getProjectsProperty()
    {
        return Project::get();
    }

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('pages.frontend.project.index');
    }
}
