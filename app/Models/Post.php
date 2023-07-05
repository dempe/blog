<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model {
    protected $table        = 'posts';
    protected $primaryKey   = 'slug';
    public    $incrementing = false;
    public    $timestamps   = true;
    protected $dateFormat   = 'Y-m-d H:i:s';

    use HasFactory;

    public function postTag(): HasMany
    {
        return $this->hasMany(PostTag::class, 'slug', 'slug');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            PostTag::class,
            'slug',
            'tag',
            'slug',
            'tag'
        );
    }
}
