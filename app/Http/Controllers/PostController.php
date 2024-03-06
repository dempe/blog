<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use DOMDocument;
use DOMXPath;
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

            $new_body = $post->body;
            $new_body = $pd->text($new_body);
            $new_body = $this->add_header_ids($new_body);

//            $post->toc = $this->build_toc($new_body, $slug);
            $post->body = $new_body;
            $post->next = Post::findNext($slug);
            $post->prev = Post::findPrev($slug);


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

    private function build_toc($body, $post_slug) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Suppress loadHTML warnings/errors
        $dom->loadHTML($body);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);
        $h2s = $xpath->query("//h2");

        $toc = '<div id="toc"><button id="toc-toggle"><span>+</span> Table of Contents</button><ul style="display: none;">';
        foreach ($h2s as $h2) {
            $toc = $toc . '<li><a href="http://localhost:8000/posts/' . $post_slug . '#' . $h2->getAttribute('id') . '">' . $h2->nodeValue .'</a></li>';
        }
        $toc = $toc . '</ul></div>';

        return $toc;
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
