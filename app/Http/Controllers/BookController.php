<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
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

        return response()->json($book);
    }

    public function store(Request $request): JsonResponse
    {
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
