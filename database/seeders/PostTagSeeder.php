<?php

namespace Database\Seeders;

use App\Models\PostTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PostTagSeeder extends Seeder
{

    public function run(): void
    {
        collect(File::files(resource_path("posts/")))
            ->flatMap(fn($file) => PostTagSeeder::parsePostTagPair($file))
            ->map(fn($pair) => PostTag::updateOrCreate($pair, $pair));
    }

    private static function parsePostTagPair($path): array
    {
        $doc = YamlFrontMatter::parseFile($path);
        $slug = $doc->slug;

        return collect(explode(" ", $doc->tags))
            ->map(fn($tag) => ['slug' => $slug, 'tag' => $tag])
            ->toArray();
    }
}
