<?php

namespace App\Http\Controllers;

use App\Models\Citation;
use Illuminate\Http\Request;

class CitationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $donneesValidees = $request->validate([
            'quote' => 'required|string|min:10|max:255',
            'author' => 'required|string|min:2|max:50',
        ]);

        $citation = Citation::create($donneesValidees);

        return response()->json($citation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Citation $citation)
    {
        $citation = Citation::findOrFail($citation->id);

        return response()->json($citation, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Citation $citation)
    {
        $donneesValidees = $request->validate([
            'quote' => 'required|string|min:10|max:255',
            'author' => 'required|string|min:2|max:50',
        ]);

        $citation = Citation::findOrFail($citation->id);
        $citation->update($donneesValidees);

        return response()->json($citation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citation $citation)
    {
        $citation = Citation::findOrFail($citation->id);
        $citation->delete();

        return response()->json(null, 204);
    }
}
