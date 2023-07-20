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
        self::seedTags();
        self::seedTagDescriptions();
    }

    private static function seedTags(): void {
        collect(File::files(resource_path("posts/")))
            ->flatMap(fn($file) => TagSeeder::parseTagFromPost($file))
            ->filter(fn($tag) => $tag != '')
            ->map(fn($tag) => Tag::updateOrCreate(['tag' => $tag], ['tag' => $tag]));
    }

    private static function seedTagDescriptions(): void {
        foreach (File::files(resource_path("tag-descriptions/")) as $file) {
            $tagName = $file->getFilenameWithoutExtension();
            $contents = File::get($file->getPathname());
            $tag = Tag::findOrFail($tagName);

            $tag->description = $contents;
            $tag->save();
        }
    }

    private static function parseTagFromPost($path): array
    {
        return explode(" ", YamlFrontMatter::parseFile($path)->tags);
    }
}
