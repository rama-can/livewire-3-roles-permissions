<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/countries', 'App\Http\Controllers\Api\CountryController')->name('country');
// Route::post('/upload-image', [ImageController::class, 'upload'])->name('upload-image');
// Route::post('/delete-image', [ImageController::class, 'delete'])->name('delete-image');
