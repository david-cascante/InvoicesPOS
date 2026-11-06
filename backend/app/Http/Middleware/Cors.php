<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Manejar preflight OPTIONS
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', 'https://invoicespos-core.test')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        // Ejecutar la aplicación
        $response = $next($request);

        // Agregar cabeceras CORS a la respuesta
        $response->header('Access-Control-Allow-Origin', 'https://invoicespos-core.test')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
