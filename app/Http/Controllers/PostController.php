<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class PostController extends Controller
{
    public function index() {
        return view('posts', ['posts' => Post::all()]);
    }

    public function show($slug) {
        try {
            return view('post', ['post' => Post::findOrFail($slug),
                                 'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
        }
        catch (ModelNotFoundException $e) {
            return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function redirect() {
        return redirect('/');
    }
}
