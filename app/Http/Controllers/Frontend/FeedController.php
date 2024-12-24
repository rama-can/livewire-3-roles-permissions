<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Markdown\MarkdownService;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::latest()->take(10)->get();

        $site = [
            'name' => __('general.site_name'),
            'description' => __('general.site_description'),
            'url' => url()->current(),
            'language' => app()->getLocale(),
            'lastBuildDate' => $posts[0]->created_at->format(\DateTime::RSS),
        ];

        return response()->view('feed', [
            'site' => $site,
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
