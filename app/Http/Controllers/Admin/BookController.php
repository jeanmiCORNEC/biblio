<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $donneesValidees = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'author' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10|max:500',
            'cover_image' => 'required|string|min:5|max:255',
            'isbn' => 'string|min:5|max:50',
            'paperLinks' => 'array|nullable',
            'paperLinks.*.link' => 'string|min:5|max:255',
            'ebookLinks' => 'array|nullable',
            'ebookLinks.*.link' => 'string|min:5|max:255',
        ]);

        $book = Book::create($donneesValidees);

        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $donneesValidees = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'author' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10|max:500',
            'cover_image' => 'required|string|min:5|max:255',
            'isbn' => 'string|min:5|max:50',
        ]);
        $bookId = $book->id;
        $book = Book::findOrFail($bookId);
        $book->update($donneesValidees);

        return response()->json($book, 200);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
