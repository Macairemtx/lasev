<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Enregistrement temporaire d'un utilisateur via l'onboarding mobile
     */
    public function registerTemporary(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'device_id' => 'required|string|max:255|unique:users,device_id',
            'objectives' => 'required|array|min:1',
            'objectives.*' => 'required|integer|exists:objectives,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Créer l'utilisateur temporaire
            $user = User::create([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'device_id' => $request->device_id,
                'email' => null,
                'password' => null,
            ]);

            // Attacher les objectifs à l'utilisateur
            $user->objectives()->attach($request->objectives);

            // Charger les objectifs pour la réponse
            $user->load('objectives');

            // Générer un token pour l'utilisateur temporaire
            $token = $user->createToken('mobile-device-' . $request->device_id)->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur enregistré avec succès',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Connexion utilisateur par email et mot de passe
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }
}
