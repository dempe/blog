<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->string('slug');
            $table->string('tag');
            $table->primary(['slug', 'tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tags');
    }
};
