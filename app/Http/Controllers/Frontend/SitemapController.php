<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::latest()->get();

        $lastmod = $posts[0]->created_at->tz('UTC')->toAtomString();

        $pages = [
            [
                'url' => route('home'),
                'lastmod' => $lastmod,
                'priority' => '1.0',
            ],
            [
                'url' => route('blogs.index'),
                'lastmod' => $lastmod,
                'priority' => '0.9',
            ],
            [
                'url' => route('projects.index'),
                'lastmod' => $lastmod,
                'priority' => '0.8',
            ],
            // [
            //     'url' => route('works.index'),
            //     'lastmod' => $lastmod,
            //     'priority' => '0.8',
            // ],
            // [
            //     'url' => route('contact'),
            //     'lastmod' => $lastmod,
            //     'priority' => '0.7',
            // ],
        ];

        return response()->view('sitemap', [
            'pages' => $pages,
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
