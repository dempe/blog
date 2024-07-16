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
use stdClass;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


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
            $new_body = PostController::open_links_in_external_tab($new_body);

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

    private static function build_dom_and_query(string $body, string $query) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Suppress loadHTML warnings/errors
        $dom->loadHTML($body);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);


        $data = new stdClass();
        $data->dom = $dom;
        $data->query_results = $xpath->query($query);;
        return $data;
    }

    private static function open_links_in_external_tab(string $body) {
        $result = self::build_dom_and_query($body, "//a");
        $anchors = $result->query_results;

        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            if ($href && self::is_external_link($href)) {
                $anchor->setAttribute('target', '_blank');
                $anchor->setAttribute('rel', 'noopener noreferrer');  // Security best practice
            }
        }

        return $result->dom->saveHTML();
    }

    private static function is_external_link($url) {
        $host = parse_url($url, PHP_URL_HOST);
        if ($host && $host !== $_SERVER['HTTP_HOST']) {
            return true;
        }
        return false;
    }

    /**
     * Add ids to all H2 headers.  Assume only H2 exist for now (they do).
     * Add isomorphic function for H3 if the case ever arises.
     * @param $body
     * @return string html
     */
    public static function add_header_ids($body): string {
        return self::add_header_ids_helper(self::add_header_ids_helper($body, "//h2"), "//h3");
    }

    public static function add_header_ids_helper($body, $query): string {
        $results = self::build_dom_and_query($body, $query);
        $headers = $results->query_results;

        foreach ($headers as $header) {
            $slug = Str::slug($header->nodeValue);
            $header->setAttribute('id', $slug);

            $a = $results->dom->createElement('a', $header->nodeValue);
            $a->setAttribute('href', "#{$slug}");
            $header->nodeValue = '';
            $header->appendChild($a);
        }

        return $results->dom->saveHTML();
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
