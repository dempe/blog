<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        /**
         * Laravel's ORM, Eloquent, doesn't seem to support setting the default timestamps
         * when using `timestamps()`.  Maybe this is bc I'm using `slug` as ID.  IDK.
         * But this is why I wrote raw SQL.
         */
        DB::statement('CREATE TABLE posts (
                slug VARCHAR(255) PRIMARY KEY,
                title VARCHAR(255),
                subhead VARCHAR(255),
                body TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
