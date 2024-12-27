<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShortLinkController extends Controller
{
    public function index(string $code)
    {
        $link = ShortLink::where('code', $code)->firstOrFail();
        $link->increment('clicks');

        return redirect($link->url, 301)
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
