<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * TenantServiceProvider
 *
 * Este provider serve como ponto central para registrar serviços
 * relacionados à multi‑tenancy.  Ele pode ser estendido para
 * compartilhar o tenant resolvido com views, jobs ou outros
 * componentes do sistema.
 */
class TenantServiceProvider extends ServiceProvider
{
    /**
     * Registra serviços de aplicação.
     */
    public function register(): void
    {
        // Nada a registrar por enquanto; o tenant é resolvido
        // dinamicamente pelo middleware.
    }

    /**
     * Executa qualquer tarefa de bootstrapping.
     */
    public function boot(): void
    {
        // Podemos compartilhar o tenant com todas as views, se necessário
        // view()->share('tenant', app()->bound('tenant') ? app('tenant') : null);
    }
}