<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckComplexe
{
    public function handle(Request $request, Closure $next): Response
    {
        // On vérifie que l'utilisateur est connecté et qu'il a le niveau "complexe"
        if (!auth()->check() || auth()->user()->niveau !== 'complexe') {
            // Retourne une vue d'erreur 403 personnalisée
            return response()->view('errors.forbidden', [
                'message' => "Accès réservé aux utilisateurs complexes. Vous n'avez pas les droits nécessaires."
            ], 403);
        }
        return $next($request);
    }
}
