<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function store(Request $request, Book $book): JsonResponse
    {
        $donneesValidees = $request->validate([
            'content' => 'required|string|min:10|max:500',
            'title' => 'required|string|min:5|max:50',
            'parent_id' => 'nullable|integer'
        ]);
        $utilisateurCourantId = Auth::id();
        $bookId = $book->id;
        $donneesValidees['user_id'] = $utilisateurCourantId;
        $donneesValidees['book_id'] = $bookId;

        $comment = Comment::create($donneesValidees);
        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {

        $donneesValidees = $request->validate([
            'content' => 'required|string|min:10|max:500',
            'title' => 'required|string|min:5|max:50',
            'parent_id' => 'nullable|integer'
        ]);

        $comment = Comment::findOrFail($comment->id);

        if (is_null($comment)) {
            return response()->json(['message' => 'Commentaire non trouvé'], 404);
        }

        $utilisateurCourant = Auth::user();

        if ($utilisateurCourant->id === $comment->user_id || $utilisateurCourant->is_admin === 1) {
            $donneesValidees['user_id'] = $comment->user_id;
            $donneesValidees['content'] = $donneesValidees['content'] . ' (modifié par un admin)';
            $comment->update($donneesValidees);
            return response()->json($comment, 200);
        }

        return response()->json(
            [
                'message' => 'Vous n\'avez pas le droit de modifier ce commentaire'
            ],
            403
        );
    }

    public function destroy(Comment $comment)
    {
        $comment = Comment::findOrFail($comment->id);

        $utilisateurCourant = Auth::user();

        if ($utilisateurCourant->id === $comment->user_id || $utilisateurCourant->is_admin === 1) {
            $comment->delete();
            return response()->json(
                [
                    'message' => 'Commentaire supprimé'
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Vous n\'avez pas le droit de supprimer ce commentaire'
            ],
            403
        );
    }
}
