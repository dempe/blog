<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class TagSeeder extends Seeder
{

    public function run(): void
    {
        collect(File::files(resource_path("posts/")))
            ->flatMap(fn($file) => TagSeeder::parseTagFromPost($file))
            ->map(fn($tag) => Tag::updateOrCreate(['tag' => $tag], ['tag' => $tag]));
    }

    private static function parseTagFromPost($path): array
    {
        return explode(" ", YamlFrontMatter::parseFile($path)->tags);
    }
}
