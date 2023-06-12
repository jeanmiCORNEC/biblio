<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaperLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'link',
        'id'
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
