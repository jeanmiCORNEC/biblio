<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $donnesValidees = $request->validate([
            'title' => 'required|unique:posts|min:5|max:255',
            'sommaire' => 'string',
            'content' => 'required|string',
            'image' => 'string',
            'FAQ' => 'string',
        ]);
        $title = $donnesValidees['title'];
        $slug = Str::replace('\'', ' ', $title);
        $slug = Str::slug($slug, '_', 'fr');
        $donnesValidees['slug'] = $slug;

        Post::create($donnesValidees);

        return response()->json([
            'message' => 'article créé avec succès',
            'post' => $donnesValidees,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = Post::findOrFail($post->id);

        return $post;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $donnesValidees = $request->validate([
            'title' => 'required|min:5|max:255',
            'sommaire' => 'string',
            'content' => 'required|string',
            'image' => 'string',
            'FAQ' => 'string',
        ]);

        $post = Post::findOrFail($post->id);

        $title = $donnesValidees['title'];
        $slug = Str::replace('\'', ' ', $title);
        $slug = Str::slug($slug, '_', 'fr');
        $donnesValidees['slug'] = $slug;

        $post->update($donnesValidees);

        return response()->json([
            'message' => 'article modifié avec succès',
            'post' => $donnesValidees,
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = Post::findOrFail($post->id);
        $post->delete();

        return response()->json([
            'message' => 'article supprimé avec succès',
        ], 200);
    }
}
