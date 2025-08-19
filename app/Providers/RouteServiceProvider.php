<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

/**
 * RouteServiceProvider
 *
 * Responsável por agrupar e carregar as rotas da aplicação.  Aqui
 * definimos grupos para rotas web, API e rotas específicas de tenant.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define o namespace base para os controladores.  Em projetos
     * modernos do Laravel, o namespace dos controladores é
     * automaticamente deduzido, portanto esta propriedade pode
     * permanecer nula.
     */
    protected $namespace = null;

    /**
     * Carrega as rotas da aplicação.
     */
    public function boot(): void
    {
        // Configura o rate limiter "api" padrão.  Este limitador controla
        // o número de requisições que um usuário (ou IP anônimo) pode
        // fazer por minuto.  Ajuste conforme necessário para sua aplicação.
        $this->configureRateLimiting();

        parent::boot();
    }

    /**
     * Define limitadores de requisição para a aplicação.
     *
     * Aqui registramos o limitador "api", utilizado nas rotas
     * protegidas pelo middleware `api`.  Você pode criar outros
     * limitadores (como "login" ou "register") conforme necessidade.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }

    /**
     * Define as rotas que serão mapeadas para a aplicação.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapTenantRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define as rotas da API.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define rotas específicas para tenants (caso queira separá‑las).
     */
    protected function mapTenantRoutes(): void
    {
        Route::prefix('api')
            ->middleware(['api', 'tenant'])
            ->group(base_path('routes/tenant.php'));
    }

    /**
     * Define as rotas web.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}