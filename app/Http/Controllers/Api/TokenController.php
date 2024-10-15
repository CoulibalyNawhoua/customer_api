<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function verifyToken()
    {
        // try {
        //     $user = Auth::guard('api')->user();
        //     return response()->json(['valid' => true, 'user' => $user]);
        // } catch (\Exception $e) {
        //     return response()->json(['valid' => false]);
        // }
        
        try {
            // Récupérer le token depuis la requête (par exemple, depuis les en-têtes)
            $token = JWTAuth::getToken();

            // Vérifier si le token est expiré
            $payload = JWTAuth::getPayload($token);
            
            // Récupérer la date d'expiration du token
            $expiration = $payload->get('exp');

            // Récupérer la date actuelle
            $now = now()->timestamp;

            if ($expiration > $now) {
                // Le token n'est pas expiré
                return response()->json(['valid' =>  true]);
            } else {
                // Le token est expiré
                return response()->json(['valid' => false], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Une exception s'est produite
            return response()->json(['message' => 'Une erreur est survenue lors de la vérification du token'], 500);
        }
    }
}
