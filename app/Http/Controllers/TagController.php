<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TagController extends Controller
{
    public function index() {
        return view('tags', ['tags' => Tag::all(),
                             'postTags' => PostTag::all(),
                             'posts' => Post::select('created_at')->get()]);  // Passing all posts here to get Published/Updated info -- just needed to copy/paste footer code from index.
    }

    public function show($query) {
        try {
            $tag = Tag::findOrFail($query);
            $posts = $tag->posts()->get();

            return view('tag', ['tag' => $tag,
                                'posts' => $posts]);
        }
        catch (ModelNotFoundException $e) {
            return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
