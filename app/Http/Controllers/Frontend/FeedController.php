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
        $posts = Post::where('status', 'published')->latest()->take(10)->get();
        $lastmod = $posts->isNotEmpty()
            ? $posts[0]->created_at->format(\DateTime::RSS)
            : now()->format(\DateTime::RSS);

        $site = [
            'name' => __('general.site_name'),
            'description' => __('general.site_description'),
            'url' => url()->current(),
            'language' => app()->getLocale(),
            'lastBuildDate' => $lastmod,
        ];

        return response()->view('feed', [
            'site' => $site,
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
