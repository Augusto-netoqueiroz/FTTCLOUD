<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * EventServiceProvider
 *
 * Responsável por registrar listeners para eventos do sistema.  Não
 * definimos eventos personalizados neste esqueleto.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Os eventos para ouvir e os listeners correspondentes.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // \App\Events\SomeEvent::class => [
        //     \App\Listeners\SomeListener::class,
        // ],
    ];

    /**
     * Registre quaisquer eventos para sua aplicação.
     */
    public function boot(): void
    {
        parent::boot();
    }
}