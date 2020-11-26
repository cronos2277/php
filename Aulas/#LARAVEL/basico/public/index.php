<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Verifique se o aplicativo está em manutenção
|--------------------------------------------------------------------------
|
| Se o aplicativo estiver no modo de manutenção / demonstração por meio do comando "down", nós
| irá requerer este arquivo para que qualquer modelo pré-renderizado possa ser mostrado
| em vez de iniciar a estrutura, o que pode causar uma exceção.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Registrar o carregador automático
|--------------------------------------------------------------------------
|
| O Composer fornece um carregador de classes gerado automaticamente e conveniente para
| esta aplicação. Só precisamos utilizá-lo! Vamos simplesmente exigir
| no script aqui, então não precisamos carregar manualmente nossas classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Execute o aplicativo
|--------------------------------------------------------------------------
|
| Assim que tivermos o aplicativo, podemos lidar com a solicitação de entrada usando
| o kernel HTTP do aplicativo. Então, iremos enviar a resposta de volta
| para o navegador deste cliente, permitindo-lhe desfrutar da nossa aplicação.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
