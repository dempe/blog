<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\View;
use Michelf\MarkdownExtra;


class FeedController extends Controller
{
    public function index()
    {
        // Convert Markdown to HTML
        $posts = Post::where('slug', '!=', 'hello-world')->get()->map(function ($post) {
            $post->body = MarkdownExtra::defaultTransform($post->body);

            return $post;
        });

        $content = View::make('feed', compact('posts'))->render();

        return response($content, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
