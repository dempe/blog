<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Tag extends Model
{
    protected $table        = 'tags';
    protected $primaryKey   = 'tag';
    public    $incrementing = false;
    public    $timestamps   = false;

    use HasFactory;

    public function postTag(): HasMany
    {
        return $this->hasMany(PostTag::class, 'tag', 'tag');
    }

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            PostTag::class,
            'tag',
            'slug',
            'tag',
            'slug'
        );
    }
}
