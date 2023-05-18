<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostTag extends Model
{
    protected $table        = 'post_tags';
    public    $timestamps   = false;

    use HasFactory;

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'slug', 'slug');
    }

    public function tag(): HasOne
    {
        return $this->hasOne(Tag::class, 'tag', 'tag');
    }
}
