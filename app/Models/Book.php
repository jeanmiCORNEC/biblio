<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'author', 'description', 'cover_image', 'isbn'];
    protected $fillable = ['title', 'author', 'description', 'cover_image', 'isbn'];
}
