<?php

declare(strict_types=1);

use App\Controllers\Web\AuthController;
use App\Controllers\Web\HomeController;
use App\Controllers\Web\PointController;

/** @var App\Core\Router $router */

$router->get(
    '/',
    [HomeController::class, 'index']
);

$router->get(
    '/pontos',
    [PointController::class, 'index']
);

$router->get(
    '/pontos/{id}',
    [PointController::class, 'show']
);

$router->get(
    '/login',
    [AuthController::class, 'loginForm']
);

$router->get(
    '/cadastro',
    [AuthController::class, 'registerForm']
);