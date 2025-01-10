<?php

namespace App\Modules\Frontend\Common;

use App\Models\Post;
use Livewire\Component;

class ListBlog extends Component
{
    public function placeholder()
    {
        return view('components.skeleton.list-card');
    }

    public function render()
    {
        $blogs = Post::latest()
            ->with('category', 'user', 'translations')
            ->where('status', 'published')
            ->get();

        return view('pages.frontend.common.list-blog', [
            'blogs' => $blogs,
        ]);
    }
}
