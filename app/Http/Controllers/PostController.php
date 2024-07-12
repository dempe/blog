<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ParsedownExtra;
use PHPUnit\Framework\Error;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Attribute\AsController;


class PostController extends Controller
{

    public function index() {
        return view('posts', ['posts' => Post::all()]);
    }

    /**
     * @throws \Exception
     */
    public function show($slug) {
        try {
            $pd = new ParsedownExtra();
            $post = Post::findOrFail($slug);

            $post->wc = str_word_count($post->body);
            $new_body = $post->body;
            $new_body = PostController::order_footnotes($new_body);
            $new_body = $pd->text($new_body);
            $new_body = PostController::add_header_ids($new_body);

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

    /**
     * Add ids to all H2 headers.  Assume only H2 exist for now (they do).
     * Add isomorphic function for H3 if the case ever arises.
     * @param $body
     * @return string html
     */
    public static function add_header_ids($body): string {
        return preg_replace_callback(
            '|^<h2>(.*)</h2>$|m',
               function ($matches) {
                   $slug = Str::slug($matches[1]);
                   $id = "{$slug}";
                   $link_path = public_path('assets/img/icons/link.svg');

                   if (!file_exists($link_path)) {
                       Log::error('Link SVG file not found: ' . $link_path);
                       return "<h2 id='{$id}'><a href='#{$id}'>{$matches[1]}</a></h2>";
                   }

                   $svg = file_get_contents($link_path);

                   return "<h2 id='{$id}'><a href='#{$id}'>{$matches[1]}</a></h2>";
//                   return "<h2 class='flex items-center' id='{$id}'><a href='#{$id}' class='inline-flex items-center'>{$matches[1]}{$svg}</a></h2>";
               },
            $body);
    }

    /**
     * @throws \Exception
     */
    public static function order_footnotes($body): string {
        $footnotePattern = '/\[\^\d+]:/';
        $footnoteRefPattern = '/\[\^\d+](?!:)/';

        /* First, ensure that the number of footnote references == number of footnotes.

           Ideally, this would be in a separate method, but putting it here makes it possible
           to unit test.  Otherwise, we'd have to copy the regexes around, which is worse than
           having a long method.
        */
        preg_match_all($footnoteRefPattern, $body, $footnotes_ref_matches);
        preg_match_all($footnotePattern, $body, $footnote_matches);
        if (sizeof($footnote_matches[0]) != sizeof($footnotes_ref_matches[0])) {
            throw new Exception("Number of footnote references does not match footnotes.");
        }

        // Number footnote references correctly
        $counter = 1;
        $body = preg_replace_callback(
            $footnoteRefPattern,
            function ($matches) use (&$counter) {
                // Sequentially replace each footnote number and increment the counter
                return '[^' . ($counter++) . ']';
            },
            $body
        );

        // Number footnotes correctly
        $counter = 1;
        $body = preg_replace_callback(
            $footnotePattern,
            function ($matches) use (&$counter) {
                // Sequentially replace each footnote number and increment the counter
                return '[^' . ($counter++) . ']:';
            },
            $body
        );

        return $body;
    }


//    private function build_toc($body, $post_slug) {
//        $dom = new DOMDocument();
//        libxml_use_internal_errors(true); // Suppress loadHTML warnings/errors
//        $dom->loadHTML($body);
//        libxml_clear_errors();
//        $xpath = new DOMXPath($dom);
//        $h2s = $xpath->query("//h2");
//
//        $toc = '<div id="toc"><button id="toc-toggle"><span>+</span> Table of Contents</button><ul style="display: none;">';
//        foreach ($h2s as $h2) {
//            $toc = $toc . '<li><a href="http://localhost:8000/posts/' . $post_slug . '#' . $h2->getAttribute('id') . '">' . $h2->nodeValue .'</a></li>';
//        }
//        $toc = $toc . '</ul></div>';
//
//        return $toc;
//    }
}
