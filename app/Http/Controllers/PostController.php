<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class PostController extends Controller
{
    public function index() {
        return view('posts', ['posts' => Post::all()]);
    }

    public function show($slug) {
        try {
            $post = Post::findOrFail($slug);
            $body = $post->body;
            $post->body = $this->add_header_ids($body);


            return view('post', ['post' => $post,
                                 'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
        }
        catch (ModelNotFoundException $e) {
            return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function redirect() {
        return redirect('/');
    }

    private function add_header_ids($body) {
        return preg_replace_callback(
            '/^(#+)\s*(.*)/m',
               function ($matches) {
                   $slug = Str::slug($matches[2]);
                   return $matches[1] . ' ' . $matches[2] . '{#' . $slug . '}';
               },
               $body);
    }

}
