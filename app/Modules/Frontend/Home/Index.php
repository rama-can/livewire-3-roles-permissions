<?php

namespace App\Modules\Frontend\Home;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('pages.frontend.home.index');
    }
}
