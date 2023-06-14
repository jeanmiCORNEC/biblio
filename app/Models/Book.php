<?php

namespace App\Models;

use App\Models\EbookLink;
use App\Models\PaperLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'title',
        'author',
        'description',
        'cover_image',
        'isbn',
        'paperLinks',
        'ebookLinks',
        'categories'
    ];
    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_image',
        'isbn',
        'paperLinks',
        'ebookLinks',
        'categories'
    ];

    public function paperLinks()
    {
        return $this->hasMany(PaperLink::class);
    }

    public function ebookLinks()
    {
        return $this->hasMany(EbookLink::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }
}
