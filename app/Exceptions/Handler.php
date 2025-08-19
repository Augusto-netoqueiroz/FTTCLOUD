<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * Handler
 *
 * Responsável por capturar e tratar exceções não tratadas na aplicação.
 */
class Handler extends ExceptionHandler
{
    /**
     * Uma lista de log levels personalizados por tipo de exceção.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [];

    /**
     * Uma lista de tipos de exceções que não devem ser reportadas.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * Uma lista das entradas que nunca devem ser exibidas em logs.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra callbacks para o tratamento de exceções.
     */
    public function register(): void
    {
        // Aqui você pode definir tratamentos customizados de erros
    }
}