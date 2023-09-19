<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $permission)
    {
        try {
            // Extrait le token de l'utilisateur de la requête
            $token = $request->bearerToken();

            // Envoyer une demande au service d'authentification pour vérifier l'autorisation
            $authenticationServiceUrl = 'http://127.0.0.1:8001/api/check-permission'; // Mettez à jour l'URL du service d'authentification
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($authenticationServiceUrl, [
                'permission' => $permission,
            ]);

            // Vérifier la réponse du service d'authentification
            if ($response->getStatusCode() == 200 && $response->json('has_permission')) {
                return $next($request); // Autorisation accordée, laissez la demande passer
            } else {
                return response('Accès non autorisé', 403); // Autorisation refusée
            }
        } catch (\Exception $e) {
            return response('Une erreur est survenue', 500); // Erreur interne du serveur
        }
    }
}


