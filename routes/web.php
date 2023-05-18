<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all(),
        'title' => 'Posts'
    ]);
});

Route::get('/posts', function () {
    return redirect('/');
});

Route::get('/about', function () {
    return view('about', [
        'title' => 'About'
    ]);
});

// TODO:  Laravel can't find ResumeController
Route::get('/resume', 'ResumeController@show');

Route::get('/posts/{post}', function ($slug) {
    return view('post', ['post' => Post::find($slug)]);
});

Route::fallback(function () {
    return view('404', [
        'title' => '404'
    ]);
});
