<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Middleware para verificar o token CSRF em requisições web.
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * Os URIs que devem ser excluídos da verificação CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Excluir API JSON se necessário
        'api/*',
        // Endpoint de login da área web.  Como as credenciais são enviadas por
        // AJAX utilizando cabeçalho Authorization e token Sanctum, a proteção
        // CSRF pode ser dispensada para simplificar a autenticação.
        'login',
    ];
}