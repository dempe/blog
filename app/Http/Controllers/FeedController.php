<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\View;
use ParsedownExtra;


class FeedController extends Controller
{
    public function index()
    {
        // Convert Markdown to HTML
        $posts = Post::all()->map(function ($post) {
            $pd = new ParsedownExtra();
            $pd->setSafeMode(true);
            $post->body = $pd->text($post->body);

            return $post;
        });

        $content = View::make('feed', compact('posts'))->render();

        return response($content, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
