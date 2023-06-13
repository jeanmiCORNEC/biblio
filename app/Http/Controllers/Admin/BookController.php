<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\EbookLink;
use App\Models\PaperLink;
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
            'ebookLinks.*.link' => 'string|min:5|max:255'
        ]);

        $bookData = $donneesValidees;
        unset($bookData['paperLinks']);
        unset($bookData['ebookLinks']);

        $book = Book::create($bookData);

        foreach ($donneesValidees['paperLinks'] as $paperLink) {
            PaperLink::create([
                'book_id' => $book->id,
                'link' => $paperLink['link']
            ]);
        }

        foreach ($donneesValidees['ebookLinks'] as $ebookLink) {
            EbookLink::create([
                'book_id' => $book->id,
                'link' => $ebookLink['link']
            ]);
        }

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
            'paperLinks' => 'array|nullable',
            'paperLinks.*.link' => 'string|min:5|max:255',
            'ebookLinks' => 'array|nullable',
            'ebookLinks.*.link' => 'string|min:5|max:255'
        ]);
        $bookId = $book->id;
        $book = Book::findOrFail($bookId);

        $bookData = $donneesValidees;
        unset($bookData['paperLinks']);
        unset($bookData['ebookLinks']);

        $book->update($bookData);

        PaperLink::where('book_id', $book->id)->delete();
        foreach ($donneesValidees['paperLinks'] as $paperLink) {
            PaperLink::create([
                'book_id' => $book->id,
                'link' => $paperLink['link']
            ]);
        }

        EbookLink::where('book_id', $book->id)->delete();
        foreach ($donneesValidees['ebookLinks'] as $ebookLink) {
            EbookLink::create([
                'book_id' => $book->id,
                'link' => $ebookLink['link']
            ]);
        }

        return response()->json($book, 200);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
