<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * AppServiceProvider
 *
 * Responsável por registrar e inicializar serviços genéricos da aplicação.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra bindings no container.
     */
    public function register(): void
    {
        // Serviços globais podem ser registrados aqui
    }

    /**
     * Inicializa qualquer bootstrapping necessário.
     */
    public function boot(): void
    {
        Blade::component('webrtc-phone', \App\View\Components\WebrtcPhone::class);
    }

    
}