<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Michelf\MarkdownExtra;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class FeedController extends Controller
{
    public function index(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory {
        // Convert Markdown to HTML
        $posts = (new Post)->where('slug', '!=', 'hello-world')->get()->map(function ($post) {
            $postFileContent = file_get_contents(resource_path("posts/$post->slug.md"));
            $post->body = MarkdownExtra::defaultTransform(YamlFrontMatter::parse($postFileContent)->body());  // The markdown content without frontmatter
            
            return $post;
        });

        $content = View::make('feed', compact('posts'))->render();

        return response($content, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
