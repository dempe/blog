<?php

use App\Http\Controllers\PostController;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

Route::get('/', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts', [PostController::class, 'redirect']);

Route::get('/tags', function () {
    return view('tags', ['tags' => Tag::all(),
                              'postTags' => PostTag::all(),
                              'posts' => Post::select('created_at')->get()]);  // Passing all posts here to get Published/Updated info -- just needed to copy/paste footer code from index.
});

Route::get('/tags/{tag}', function ($query) {
    try {
        $tag = Tag::findOrFail($query);
        $posts = $tag->posts()->get();

        return view('tag', ['tag' => $tag,
                                 'posts' => $posts]);
    }
    catch (ModelNotFoundException $e) {
        return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
    }
});

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
