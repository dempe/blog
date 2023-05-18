<?php

use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all()]);
});

Route::get('/posts/{post}', function ($slug) {
    try {
        return view('post', ['post' => Post::findOrFail($slug)]);
    } catch (ModelNotFoundException $e) {
        return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
    }
});

Route::get('/posts', function () {
    return redirect('/');
});

Route::get('/tags', function () {
    return view('tags', [
        'tags' => Tag::all(),
        'postTags' => PostTag::all()
    ]);
});

Route::get('/tags/{tag}', function ($tag) {
    try {
        return view('tag', ['tag' => Tag::findOrFail($tag)]);
    } catch (ModelNotFoundException $e) {
        return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
    }
});

Route::get('/about', function () {
    return view('about');
});

// TODO:  Laravel can't find ResumeController
Route::get('/resume', 'ResumeController@show');

Route::fallback(function () {
    return view('404');
});
