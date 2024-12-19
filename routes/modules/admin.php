<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DataFeedController;
use App\Http\Controllers\Admin\DashboardController;

Route::namespace('App\Modules')->group(function () {
    Route::get('/users', 'Admin\User\Index')->name('users.index');
    Route::get('/users/create', 'Admin\User\Create')->name('users.create');
    Route::get('/users/{id}/edit', 'Admin\User\Edit')->name('users.edit');
    Route::get('/roles', 'Admin\Role\Resource')->name('roles.index');
    Route::get('/permissions', 'Admin\Permission\Resource')->name('permissions.index');
    Route::get('/translations', 'Admin\Translation\Resource')->name('translations.index');
    Route::get('/settings', 'Admin\Setting\Resource')->name('settings.index');
    Route::get('/audit-logs', 'Admin\AuditLog\Index')->name('audit-logs.index');
    Route::get('/audit-logs/{id}', 'Admin\AuditLog\View')->name('audit-logs.view');

    Route::get('/categories', 'Admin\Category\Resource')->name('categories.index');
    Route::get('/posts', 'Admin\Post\Index')->name('posts.index');
    Route::get('/posts/create', 'Admin\Post\Create')->name('posts.create');
    Route::get('/posts/{id}/edit', 'Admin\Post\Edit')->name('posts.edit');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');
Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');
Route::fallback(function () {
    return view('pages/admin/utility/404');
})->name('admin.fallback');
