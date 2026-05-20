<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuditLogController;

// ── Públicas ──────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('login',           [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
});

// ── Protegidas con JWT ────────────────────────────────
Route::middleware(['auth:api'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('logout',  [AuthController::class, 'logout']);
        Route::get('me',       [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    // Productos
    Route::prefix('products')->middleware('permission:products')->group(function () {
        Route::get('/',             [ProductController::class, 'index']);
        Route::post('/',            [ProductController::class, 'store']);
        Route::get('/export/pdf',   [ProductController::class, 'exportPdf']);
        Route::get('/export/excel', [ProductController::class, 'exportExcel']);
        Route::get('/{id}',         [ProductController::class, 'show']);
        Route::put('/{id}',         [ProductController::class, 'update']);
        Route::delete('/{id}',      [ProductController::class, 'destroy']);
    });

    // Usuarios
    Route::prefix('users')->middleware('permission:users')->group(function () {
        Route::get('/',             [UserController::class, 'index']);
        Route::post('/',            [UserController::class, 'store']);
        Route::get('/export/pdf',   [UserController::class, 'exportPdf']);
        Route::get('/export/excel', [UserController::class, 'exportExcel']);
        Route::get('/{id}',         [UserController::class, 'show']);
        Route::put('/{id}',         [UserController::class, 'update']);
        Route::delete('/{id}',      [UserController::class, 'destroy']);
    });

    // Perfiles
    Route::prefix('profiles')->middleware('permission:profiles')->group(function () {
        Route::get('/',             [ProfileController::class, 'index']);
        Route::post('/',            [ProfileController::class, 'store']);
        Route::get('/export/pdf',   [ProfileController::class, 'exportPdf']);
        Route::get('/export/excel', [ProfileController::class, 'exportExcel']);
        Route::get('/{id}',         [ProfileController::class, 'show']);
        Route::put('/{id}',         [ProfileController::class, 'update']);
        Route::delete('/{id}',      [ProfileController::class, 'destroy']);
    });

    // ── Bitácora (solo administradores con permiso 'profiles') ─
    Route::prefix('audit-logs')
       ->middleware('permission:profiles')
       ->group(function () {
        Route::get('/',                        [AuditLogController::class, 'index']);
        Route::get('/stats',                   [AuditLogController::class, 'stats']);
        Route::get('/{model}/{modelId}',       [AuditLogController::class, 'history']);
    });
});