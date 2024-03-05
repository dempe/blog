<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use ParsedownExtra;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class PostController extends Controller
{
    public function index() {
        return view('posts', ['posts' => Post::all()]);
    }

    public function show($slug) {
        try {
            $pd = new ParsedownExtra();
            $post = Post::findOrFail($slug);

            $tmp_body = $post->body;
            $tmp_body = $pd->text($tmp_body);
            $tmp_body = $this->add_header_ids($tmp_body);
            $tmp_body = $this->add_toc($tmp_body);

            $post->body = $tmp_body;


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

    private function add_toc($body) {
        return $body;
    }

    /**
     * Add ids to all H2 headers.  Assume only H2 exist for now (they do).
     * Add isomorphic function for H3 if the case ever arises.
     * @param $body
     * @return string html
     */
    private function add_header_ids($body) {
        return preg_replace_callback(
            '|^<h2>(.*)</h2>$|m',
               function ($matches) {
                   $slug = Str::slug($matches[1]);
                   return "<h2 id='{$slug}'>{$matches[1]}</h2>";
               },
            $body);
    }

}
