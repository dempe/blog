<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $primaryKey   = 'slug';
    public    $incrementing = false;
    public $timestamps = true;

    use HasFactory;
}
