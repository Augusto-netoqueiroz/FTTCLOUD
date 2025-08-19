<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\TenantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar rotas de API para sua aplicação.  Estas
| rotas são carregadas pelo RouteServiceProvider e atribuídas ao
| namespace "App\Http\Controllers".  Todas as rotas aqui definidas
| retornam JSON por convenção.
*/

// Rota pública para criar um novo tenant e seu primeiro usuário
Route::post('/register', [AuthController::class, 'registerTenant']);

// As rotas a seguir requerem resolução de tenant
Route::middleware(['tenant'])->group(function () {
    // Autenticação
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/users', [AuthController::class, 'registerUser'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Chamadas
    Route::get('/calls', [CallController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/calls', [CallController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/calls/{call}', [CallController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/calls/{call}', [CallController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/calls/{call}', [CallController::class, 'destroy'])->middleware('auth:sanctum');
});

// Rotas administrativas globais (sem multi‑tenant) para gerenciamento de tenants
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::get('/tenants/{tenant}', [TenantController::class, 'show']);
    Route::put('/tenants/{tenant}', [TenantController::class, 'update']);
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user-session/pause/start', [UserSessionController::class, 'startPause']);
    Route::post('/user-session/pause/end',   [UserSessionController::class, 'endPause']);
});