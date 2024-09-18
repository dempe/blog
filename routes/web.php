<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts', [PostController::class, 'redirect']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);
//Route::get('/resume', [ResumeController::class, 'show']);
Route::get('/feed.rss', [FeedController::class, 'index']);
Route::get('/assets/js/highlight.min.js', [AssetController::class, 'getJavaScript']);

Route::get('/about', function () {
    return view('about');
});

Route::get('/foo', function () {
    return view('foo');
});

// Adding the following so wget will pull down the 404 page
Route::get('/404', function () {
    return view('404');
});

// Adding the following so wget will pull down the error page
Route::get('/error', function () {
    return view('error');
});

Route::fallback(function () {
    return view('404');
});
