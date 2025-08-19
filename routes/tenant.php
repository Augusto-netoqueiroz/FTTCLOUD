<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Este arquivo contém rotas específicas para tenants, que são
| automaticamente agrupadas pelo middleware de resolução de tenant.  Se
| preferir manter as rotas de tenant em um arquivo separado para
| organização, basta incluí‑lo no RouteServiceProvider.
*/

Route::middleware(['tenant', 'auth:sanctum'])->group(function () {
    Route::get('/calls', [CallController::class, 'index']);
});