<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\TenantSettingsController;
 

/*
|--------------------------------------------------------------------------
| Rotas Públicas (sem tenant)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('login'))->name('login');
    Route::get('/register', fn () => view('register'))->name('register');
    Route::get('/forgot', fn () => view('forgot'))->name('forgot');

    // POST de login (form tradicional)
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

// Landing pages públicas
Route::get('/', fn () => view('contrucao'))->name('home');
Route::get('/roadmap', fn () => view('roadmap'))->name('roadmap');
Route::get('/teste', fn () => view('teste'))->name('teste');

// Cria novo tenant + usuário administrador (público)
Route::post('/register-tenant', [AuthController::class, 'registerTenant'])
    ->name('register-tenant');

/*
|--------------------------------------------------------------------------
| Rotas protegidas (auth + tenant)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/manage', fn () => view('manage'))->name('manage');

    // Cria novo usuário no tenant atual
    Route::post('/register-user', [AuthController::class, 'registerUser'])
        ->name('register-user');

    // Logout via POST
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Utilitários
|--------------------------------------------------------------------------
*/
Route::post('/theme/toggle', function (Request $request) {
    $theme = in_array($request->input('theme'), ['light','dark']) ? $request->input('theme') : 'light';
    session(['theme' => $theme]);
    return response()->json(['ok' => true, 'theme' => $theme]);
})->name('theme.toggle');

Route::get('/session/info', function () {
    if (!auth()->check()) {
        return response()->json(['status' => 'offline'], 200);
    }
    return response()->json([
        'status'     => session('user_status', 'available'),
        'started_at' => session('session_start') ?: now()->toIso8601String(),
    ]);
})->name('session.info');

/*
|--------------------------------------------------------------------------
| Usuários
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


/*
|--------------------------------------------------------------------------
| Convites / inquilinos 
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/settings/tenant', [TenantSettingsController::class, 'edit'])->name('tenant.settings');
    Route::post('/settings/tenant', [TenantSettingsController::class, 'update'])->name('tenant.settings.update');

    Route::get('/invites', [InviteController::class, 'index'])->name('invites.index');
    Route::post('/invites', [InviteController::class, 'store'])->name('invites.store');
    Route::delete('/invites/{invite}', [InviteController::class, 'destroy'])->name('invites.destroy');
    Route::get('/invites/accept/{token}', [InviteController::class, 'accept'])->name('invites.accept');
});