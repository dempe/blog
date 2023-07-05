<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            PostTag::class,
            'tag',
            'slug',
            'tag',
            'slug'
        );
    }
}
