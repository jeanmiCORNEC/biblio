<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $utilisateurDonnee = $request->validate([

            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|same:password'
        ]);

        $utilisateur = User::create([
            'name' => $utilisateurDonnee['name'],
            'email' => $utilisateurDonnee['email'],
            'password' => Hash::make($utilisateurDonnee['password'])
        ]);

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'utilisateur' => $utilisateur,
            'token' => $token,
            'message' => 'Utilisateur créé avec succès'
        ], 201);
    }

    public function login(Request $request)
    {
        $utilisateurDonnee = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        $utilisateur = User::where('email', $utilisateurDonnee['email'])->first();

        if (!$utilisateur || !Hash::check($utilisateurDonnee['password'], $utilisateur->password)) {
            return response()->json([
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'utilisateur' => $utilisateur,
            'token' => $token,
            'message' => 'Connexion réussie'
        ], 200);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->user()->currentAccessToken()->delete();

        return redirect()->route('/');
    }

    public function show($id): JsonResponse
    {
        $utilisateur = User::findOrFail($id);

        if (!$utilisateur) {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        return response()->json([
            'utilisateur' => $utilisateur
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $utilisateur = User::findOrFail($id);

        if (!$utilisateur) {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $utilisateurDonnee = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users,email,' . $utilisateur->id,
            'password' => 'required|string|confirmed|min:8'
        ]);

        $utilisateur->name = $utilisateurDonnee['name'];
        $utilisateur->email = $utilisateurDonnee['email'];
        $utilisateur->password = Hash::make($utilisateurDonnee['password']);
        $utilisateur->save();

        return response()->json([
            'utilisateur' => $utilisateur,
            'message' => 'Utilisateur mis à jour avec succès'
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $utilisateur = User::findOrFail($id);

        if (!$utilisateur) {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $utilisateur->delete();

        return response()->json([
            'message' => 'Utilisateur supprimé avec succès'
        ], 200);
    }
}
