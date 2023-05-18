<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PostSeeder extends Seeder
{

    public function run(): void
    {
        collect(File::files(resource_path("posts/")))
            ->map(fn($file) => PostSeeder::parsePostFromPath($file))
            ->map(fn($post_arr) => Post::updateOrCreate(['slug' => $post_arr['slug']], $post_arr));
    }

    private static function parsePostFromPath($path): array
    {
        $document = YamlFrontMatter::parseFile($path);

        if ($document->published) {
            return ['slug' => $document->slug,
                    'title' => $document->title,
                    'created_at' => $document->published,
                    'body' => $document->body()];
        }
        return ['slug' => $document->slug,
                'title' => $document->title,
                'body' => $document->body()];
    }
}
