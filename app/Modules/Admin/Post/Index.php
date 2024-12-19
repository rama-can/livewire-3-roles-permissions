<?php

namespace App\Modules\Admin\Post;

use Livewire\Component;
use Livewire\Attributes\Title;

class Index extends Component
{
    #[Title('Posts')]
    public function render()
    {
        return view('pages.admin.post.index');
    }
}
