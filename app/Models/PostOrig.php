<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PostOrig extends Page {

    private $tags;

    public function __construct($title, $published, $slug, $subHead, $body, $mTime, $tags) {
        parent::__construct($title, $published, $slug, $subHead, $body, $mTime);

        $this->tags = $tags;
    }

    public static function all() {
        return collect(File::files(resource_path("posts/")))
            ->map(fn($file) => PostOrig::parsePostFromPath($file))
            ->sortByDesc(fn ($post) => $post->getPublished());
    }


    public static function find($slug) {
        if (!file_exists($path = resource_path("posts/{$slug}.html"))) {
            throw new ModelNotFoundException();
        }

        // Cache for 5 seconds.
        return cache()->remember("posts.{$slug}", 5, fn() => PostOrig::parsePostFromPath($path));
    }

    private static function parsePostFromPath($path): PostOrig {
        $document = YamlFrontMatter::parseFile($path);
        return new PostOrig($document->title,
                            $document->published,
                            $document->slug,
                            $document->subhead,
                            $document->body(),
                            filemtime($path),
                            $document->tags);
    }

    /**
     * @return mixed
     */
    public function getTags() {
        return $this->tags;
    }
}
