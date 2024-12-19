<?php

namespace App\Modules\Frontend\Work;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('pages.frontend.work.index');
    }
}
