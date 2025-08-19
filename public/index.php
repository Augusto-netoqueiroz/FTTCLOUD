<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Autoloader
|--------------------------------------------------------------------------
|
| O autoloader gerado pelo Composer fornece automaticamente o
| carregamento das classes de nossa aplicação e dos pacotes externos.
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| O aplicativo real é criado aqui, e retornado no final deste script
| para que possamos isolar a criação da instância.
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Depois de ter a aplicação, tratamos a requisição HTTP recebida através
| do kernel e enviamos a resposta de volta ao navegador.  Em seguida,
| encerramos o processo de execução da aplicação (terminating).
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);