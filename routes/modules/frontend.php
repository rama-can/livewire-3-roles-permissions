<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/
Route::prefix(LaravelLocalization::setLocale())
    ->middleware([
        // LocaleSessionRedirect::class,
        // LocaleCookieRedirect::class,
        LaravelLocalizationRoutes::class,
        LaravelLocalizationRedirectFilter::class,
        LaravelLocalizationViewPath::class,
    ])->group(function () {
        Route::get('/feed.xml', [App\Http\Controllers\Frontend\FeedController::class, '__invoke'])->name('rss');
        Route::get('/sitemap.xml', [App\Http\Controllers\Frontend\SitemapController::class, '__invoke'])->name('sitemap');

        Route::namespace('App')->group(function () {
            Route::get('/', 'Modules\Frontend\Home\Index')->name('home');
            Route::get('/projects', 'Modules\Frontend\Project\Index')->name('projects.index');
            Route::get('/blogs', 'Modules\Frontend\Blog\Index')->name('blogs.index');
            Route::get('/{slug}', 'Modules\Frontend\Blog\Detail')->name('blogs.detail');
            // Route::get('/works', 'Modules\Frontend\Work\Index')->name('works.index');
        });
    });
