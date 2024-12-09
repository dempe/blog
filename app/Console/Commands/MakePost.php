<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakePost extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:post {title} {subhead} {tags}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a blog post given a title and space-delimited list of tags';

    /**
     * Execute the console command.
     */
    public function handle() {
        $title = $this->argument('title');
        $slug = Str::slug($title);
        $subhead = $this->argument('subhead');
        $tags = $this->argument('tags');
        $published = date('Y-m-d H:i:s');
        $filename = resource_path("/posts/$slug.md");
        $content = '---' . "\ntitle: \"$title\"\n" . "slug: $slug\n" . "slug: $subhead\n" . "tags: $tags\n" . "published: $published\n" . '---' . "\n";

        $this->writeFile($filename, $content);
        echo "Wrote $filename\n\n$content";
    }

    private function writeFile($filename, $content)
    {
        $f = fopen($filename, 'w');

        if (!$f) {
            die('Error creating the file ' . $filename);
        }

        fputs($f, $content);

        fclose($f);
    }
}
