<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $donneesValidees = $request->validate([
            'content' => 'required|string|min:10|max:500',
            'title' => 'required|string|min:5|max:50',
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'parent_id' => 'nullable|integer'
        ]);
        $comment = Comment::create($donneesValidees);
        return response()->json($comment, 201);
    }

    public function update(Request $request)
    {
        $donneesValidees = $request->validate([
            'content' => 'required|string|min:10|max:500',
            'title' => 'required|string|min:5|max:50',
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'parent_id' => 'nullable|integer'
        ]);
        $comment = Comment::findOrFail($request->id);

        if (is_null($comment)) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->update($donneesValidees);
        return response()->json($comment, 200);
    }

    public function destroy(Request $request)
    {
        //
    }
}
