<?php

namespace App\Modules\Frontend\Blog;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;

class Detail extends Component
{
    public $post;

    public function mount($slug)
    {
        $locale = app()->getLocale();
        $this->post = Post::whereTranslation('slug', $slug, $locale)
            ->with(['user', 'category'])
            // ->where('status', 'published')
            ->firstOrFail();
    }

    public function placeholder()
    {
        return view('components.skeleton.blog-detail');
    }

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('pages.frontend.blog.detail');
    }
}
