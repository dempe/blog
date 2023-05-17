<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Page;


Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all(),
        'page' => new Page('Posts', '1675659720', '', '', filemtime(resource_path('views/posts.blade.php')))
    ]);
});

Route::get('/posts/{post}', function ($slug) {
    return view('post', ['post' => Post::find($slug)]);
});

Route::fallback(function () {
    return view('404', [
        'page' => new Page('404', '1675659600', '', '', '')
    ]);
});
