<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use \Spatie\YamlFrontMatter\YamlFrontMatter;

class Post {

    private $title;
    private $published;
    private $tags;
    private $slug;
    private $body;
    private $mTime;


    public function __construct($title, $published, $tags, $slug, $body, $mTime) {
        $this->title = $title;
        $this->published = $published;
        $this->tags = $tags;
        $this->slug = $slug;
        $this->body = $body;
        $this->mTime = $mTime;
    }


    public static function all() {
        return collect(File::files(resource_path("posts/")))
            ->map(fn($file) => Post::parsePostFromPath($file))
            ->sortByDesc(fn ($post) => $post->getPublished());
    }


    public static function find($slug) {
        if (!file_exists($path = resource_path("posts/{$slug}.html"))) {
            throw new ModelNotFoundException();
        }

        // Cache for 5 seconds.
        return cache()->remember("posts.{$slug}", 5, fn() => Post::parsePostFromPath($path));
    }

    private static function parsePostFromPath($path): Post {
        $document = YamlFrontMatter::parseFile($path);
        return new Post($document->title, $document->published, $document->tags, $document->slug, $document->body(), filemtime($path));
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * @return mixed
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getMTime() {
        return $this->mTime;
    }
}
