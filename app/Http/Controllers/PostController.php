<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Michelf\MarkdownExtra;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use stdClass;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Highlight\Highlighter;



class PostController extends Controller {
    public function index() {
        return view('posts', ['posts' => Post::all()]);
    }

    /**
     * @throws \Exception
     */
    public function show($slug): Factory|\Illuminate\Foundation\Application|View|Response|Application {
        try {
            $post = Post::findOrFail($slug);
            $postFileContent = file_get_contents(resource_path("posts/$slug.md"));
            $body = YamlFrontMatter::parse($postFileContent)->body();  // The markdown content without frontmatter


            $post->wc = str_word_count($body);
            Artisan::call('view:clear');
            $body = Blade::render($body, [], true);

            $body = MarkdownExtra::defaultTransform($body);
            $body = self::addHeaderIDs($body);
            $body = self::openLinksInNewTab($body);
            $body = self::highlightCodeBlocks($body);

            $post->toc = self::buildTOC($body);
            $post->body = $body;
            $post->next = Post::findNext($slug);
            $post->prev = Post::findPrev($slug);


            return view('layouts/post', ['post' => $post, 'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
        }
        catch (ModelNotFoundException) {
            return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function redirect(): \Illuminate\Foundation\Application|Redirector|Application|RedirectResponse {
        return redirect('/');
    }

    private static function buildDOMAndQuery(string $body, string $query): stdClass {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true); // Suppress loadHTML warnings/errors
        $dom->loadHTML('<?xml encoding="UTF-8">' . $body);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);


        $data = new stdClass();
        $data->dom = $dom;
        $data->query_results = $xpath->query($query);;
        return $data;
    }

    private static function openLinksInNewTab(string $body) {
        $result = self::buildDOMAndQuery($body, "//a");
        $anchors = $result->query_results;

        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            if ($href && self::isExternalLink($href)) {
                $anchor->setAttribute('target', '_blank');
                $anchor->setAttribute('rel', 'noopener noreferrer');  // Security best practice
            }
        }

        return $result->dom->saveHTML();
    }

    private static function isExternalLink($url): bool {
        $host = parse_url($url, PHP_URL_HOST);
        return $host && $host !== $_SERVER['HTTP_HOST'];
    }

    /**
     * Add ids to all H2 headers.  Assume only H2 exist for now (they do).
     * Add isomorphic function for H3 if the case ever arises.
     *
     * @param $body
     * @return string html
     */
    public static function addHeaderIDs($body): string {
        return self::addHeaderIDsHelper(self::addHeaderIDsHelper($body, "//h2"), "//h3");
    }

    public static function addHeaderIDsHelper($body, $query): string {
        $results = self::buildDOMAndQuery($body, $query);
        $headers = $results->query_results;

        foreach ($headers as $header) {
            $slug = Str::slug($header->nodeValue);
            $header->setAttribute('id', $slug);

            $a = $results->dom->createElement('a', $header->nodeValue);
            $header->nodeValue = '';
            $a->setAttribute('href', "#{$slug}");
            $a->setAttribute('class', "w-full block");
            $header->appendChild($a);
        }

        return $results->dom->saveHTML();
    }

    public static function highlightCodeBlocks(string $body) : string
    {
        $highlighter = new Highlighter();
        $result = self::buildDOMAndQuery($body, '//pre/code');
        $dom = $result->dom;
        $codeBlocks = $result->query_results;

        foreach ($codeBlocks as $codeBlock) {
            $classes = $codeBlock->getAttribute('class');
            if (preg_match('/language-(\w+)/', $classes, $matches)) {
                $language = $matches[1];
            } else {
                $language = 'plaintext';
            }

            $code = $codeBlock->textContent;

            try {
                $highlighted = $highlighter->highlight($language, $code);

                // Create a new <code> element with the language class
                $newCodeElement = $dom->createElement('code');
                $newCodeElement->setAttribute('class', 'hljs language-' . $language);

                // Append the highlighted HTML as a text node to the new <code> element
                $highlightedFragment = $dom->createDocumentFragment();
                $highlightedFragment->appendXML($highlighted->value);
                $newCodeElement->appendChild($highlightedFragment);

                // Replace the existing <code> block with the new one
                $codeBlock->parentNode->replaceChild($newCodeElement, $codeBlock);
            } catch (\Exception $e) {
                // If there's an error, leave the original code block intact
                continue;
            }
        }

        return $dom->saveHTML();
    }

    private static function buildTOC($body): string {
        $data = self::buildDOMAndQuery($body, "//h2");
        $h2s = $data->query_results;
        $toc = '<aside id="toc" class="mb-8"><details><summary class="font-bold">Table of Contents</summary><ul>';

        foreach ($h2s as $h2) {
            $toc .= '<li><a href="#' . $h2->getAttribute('id') . '">' . $h2->nodeValue . '</a>';

            $h3s = self::findSiblingElements($h2, 'h3');

            if (count($h3s) === 0) {
                $toc .= '</li>';
                continue;
            }

            $toc .= '<ul>';
            foreach ($h3s as $h3) {
                $toc .= '<li><a href="#' . $h3->getAttribute('id') . '">' . $h3->nodeValue . '</a></li>';
            }
            $toc .= '</ul></li>';
        }

        $toc .= '<li><a href="#comments">Comments</a><ul><li><a href="#replies">Replies</a></li></ul></li>';
        $toc .= '</ul></details></aside>';

        return $toc;
    }


    private static function findSiblingElements($node, $tag): array {
        $siblings = [];
        $current = $node->nextSibling;
        while ($current) {
            if ($current->nodeName === $tag) {
                $siblings[] = $current;
            }
            if ($current->nodeName === 'h2') {
                break; // Stop if we reach the next h2
            }
            $current = $current->nextSibling;
        }
        return $siblings;
    }

}
