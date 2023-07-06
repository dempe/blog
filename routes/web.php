<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts', [PostController::class, 'redirect']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);

Route::get('/about', function () {
    return view('about');
});

// Adding the following so wget will pull down the 404 page
Route::get('/404', function () {
    return view('404');
});

// Adding the following so wget will pull down the error page
Route::get('/error', function () {
    return view('error');
});

// TODO:  Laravel can't find ResumeController
Route::get('/resume', 'ResumeController@show');

Route::fallback(function () {
    return view('404');
});
