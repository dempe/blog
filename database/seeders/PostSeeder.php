<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i = 0; $i < 10; $i++) {
            $slugtitle = Str::random(10);
            DB::table('posts')->insert(['title' => $slugtitle,
                                        'body' => 'Lorem ipsum.',
                                        'slug' => $slugtitle]);
        }
    }
}
