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
            'password' => 'required|string|confirmed|min:8'
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
