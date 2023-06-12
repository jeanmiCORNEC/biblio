<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'parent_id',
        'book_id',
        'title'
    ];

    protected $visible = [
        'id',
        'content',
        'user_id',
        'parent_id',
        'book_id',
        'title',
        'created_at',
        'updated_at',
        'user',
        'parent',
        'replies'
    ];


    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
