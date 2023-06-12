<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Comment;
use App\Models\EbookLink;
use App\Models\PaperLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{
    public function index()
    {

        return Book::all();
    }

    public function show(Book $book): JsonResponse
    {
        $book = Book::findOrFail($book->id);

        if (is_null($book)) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // on récupere les commentaires du livre
        $comment = Comment::where('book_id', $book->id)->get();

        // on récupere les liens papier du livre
        $paperLinks = PaperLink::where('book_id', $book->id)->get();

        // on récupere les liens ebook du livre
        $ebookLinks = EbookLink::where('book_id', $book->id)->get();

        return response()->json(
            [
                'book' => $book,
                'paperLinks' => $paperLinks,
                'ebookLinks' => $ebookLinks,
                'comment' => $comment
            ],
            200
        );
    }
}
