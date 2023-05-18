<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table        = 'tags';
    protected $primaryKey   = 'tag';
    public    $incrementing = false;
    public    $timestamps   = false;

    use HasFactory;
}
