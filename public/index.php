<?php

/*Comando para iniciar o host local:

        C:\xampp\php\php.exe -S localhost:8000 -t public public/index.php 

*/


declare(strict_types=1);

use App\Core\Request;
use App\Core\Router;


/*
|--------------------------------------------------------------------------
| Arquivos estáticos
|--------------------------------------------------------------------------
|
| Quando usamos o servidor interno do PHP, deixamos CSS, JS e imagens
| serem entregues diretamente pelo servidor.
|
*/

if (PHP_SAPI === 'cli-server') {

    $path = parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    );

    $file = __DIR__ . $path;

    if (
        $path !== '/' &&
        is_file($file)
    ) {
        return false;
    }
}


/*
|--------------------------------------------------------------------------
| Inicialização
|--------------------------------------------------------------------------
*/

require_once dirname(__DIR__)
    . '/config/bootstrap.php';


/*
|--------------------------------------------------------------------------
| Requisição e Router
|--------------------------------------------------------------------------
*/

$request = new Request();

$router = new Router();


/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
*/

require dirname(__DIR__)
    . '/routes/web.php';


/*
|--------------------------------------------------------------------------
| Execução
|--------------------------------------------------------------------------
*/

$router->dispatch($request);