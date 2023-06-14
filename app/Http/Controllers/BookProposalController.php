<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\BookProposalMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;

class BookProposalController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'author' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10|max:500',
            'cover_image' => 'required|string|min:5|max:255',
            'isbn' => 'string|min:5|max:50',
        ]);

        $validatedData['ebookLinks'] = [];
        $validatedData['paperLinks'] = [];

        if (isset($request['paperLinks'])) {
            $validatedData['paperLinks'] = $request->input('paperLinks');
        }

        if (isset($request['ebookLinks'])) {
            $validatedData['ebookLinks'] = $request->input('ebookLinks');
        }


        Mail::to('maelgut@hotmail.fr')->send(new BookProposalMail($validatedData));

        return response()->json([
            'message' => 'Votre proposition a bien été envoyée !'
        ], 201);
    }
}
