<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido o expirado.',
            ], 401);
        }

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ], 401);
        }

        // Cargar perfil con permisos
        $profile = $user->profile;

        if (! $profile) {
            return response()->json([
                'success' => false,
                'message' => 'Sin perfil asignado.',
            ], 403);
        }

        $permissions = $profile->permissions ?? [];

        if (! in_array($permission, $permissions, true)) {
            return response()->json([
                'success' => false,
                'message' => "Sin acceso al módulo: {$permission}.",
            ], 403);
        }

        return $next($request);
    }
}