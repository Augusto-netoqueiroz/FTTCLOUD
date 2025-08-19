<?php

use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Aqui criamos a instância do aplicativo Laravel que atuará como
| contêiner IoC central para todos os componentes do framework.
*/

$app = new Application(
    dirname(__DIR__)
);

// Define o diretório "app" personalizado (padrão é app/)
$app->useAppPath(
    $app->basePath('app')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Aqui vinculamos as interfaces que serão usadas pelo framework.  Elas
| fornecem kernels para a aplicação HTTP e CLI, bem como o handler de
| exceções.
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| Esta instância será retornada para o script invocador.  Mantemos
| essa separação para que o arquivo de bootstrap tenha clareza.
*/

return $app;