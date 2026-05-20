<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // ── Login ────────────────────────────────────────────
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = JWTAuth::attempt($credentials);
        } catch (JWTException $e) {
            return $this->error('No se pudo generar el token.', 500);
        }
        if (! $token) {
            return $this->error('Credenciales incorrectas.', 401);
        }
        $user = auth()->user();
        if (! $user->is_active) {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->error('Usuario inactivo.', 403);
        }
        return $this->respondWithToken($token, $user);
    }

    // ── Logout ───────────────────────────────────────────
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException) {
            return $this->error('No se pudo cerrar la sesión.', 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    // ── Usuario autenticado ───────────────────────────────
    public function me(): JsonResponse
    {
        $user = auth()->user()->load('profile');

        return response()->json([
            'success' => true,
            'data'    => $user,
        ]);
    }

    // ── Refresh token ────────────────────────────────────
    public function refresh(): JsonResponse
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException) {
            return $this->error('No se pudo refrescar el token.', 401);
        }

        return $this->respondWithToken($token, auth()->user());
    }

    // ── Recuperar contraseña ─────────────────────────────
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            // No revelar si el email existe (seguridad)
            return response()->json([
                'success' => true,
                'message' => 'Si el correo existe, recibirás las instrucciones.',
            ]);
        }

        $newPassword = Str::random(10);
        $user->update(['password' => Hash::make($newPassword)]);

        Mail::to($user->email)->send(
            new \App\Mail\ForgotPasswordMail($user, $newPassword)
        );

        return response()->json([
            'success' => true,
            'message' => 'Si el correo existe, recibirás las instrucciones.',
        ]);
    }

    // ── Helpers ──────────────────────────────────────────
    private function respondWithToken(string $token, $user): JsonResponse
    {
        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => config('jwt.ttl') * 60,
            'user'         => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'permissions' => $user->profile?->permissions ?? [],
            ],
        ]);
    }

    private function error(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}