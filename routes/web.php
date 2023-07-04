<?php

use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

Route::get('/', function () {
    return view('posts', ['posts' => Post::all()]);
});

Route::get('/posts/{post}', function ($slug) {
    try {
        return view('post', ['post' => Post::findOrFail($slug),
                                  'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
    }
    catch (ModelNotFoundException $e) {
        return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
    }
});

Route::get('/posts', function () {
    return redirect('/');
});

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

// TODO:  Laravel can't find ResumeController
Route::get('/resume', 'ResumeController@show');

Route::fallback(function () {
    return view('404');
});
