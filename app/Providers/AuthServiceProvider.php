<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * AuthServiceProvider
 *
 * Define políticas e autorizações do sistema.  Neste esqueleto não
 * existem políticas mapeadas por padrão, mas você pode adicioná‑las
 * conforme necessário.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento das políticas de modelo para as classes de política.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registra qualquer serviço de autenticação/autorização.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Exemplo de gate: somente usuários com papel 'admin' podem acessar rotas de administração
        Gate::define('access-admin', function ($user) {
            return $user->hasRole('admin');
        });
    }
}