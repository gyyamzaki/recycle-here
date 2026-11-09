<?php

declare(strict_types=1);

use App\Controllers\Api\AuthController;
use App\Controllers\Api\CollectionPointController;
use App\Controllers\Api\MaterialController;

/** @var App\Core\Router $router */

$router->post(
    '/api/auth/login',
    [AuthController::class, 'login']
);

$router->get(
    '/api/auth/me',
    [AuthController::class, 'me']
);

$router->post(
    '/api/auth/logout',
    [AuthController::class, 'logout']
);

$router->get(
    '/api/materiais',
    [MaterialController::class, 'index']
);

$router->get(
    '/api/pontos',
    [CollectionPointController::class, 'index']
);

$router->get(
    '/api/pontos/{id}',
    [CollectionPointController::class, 'show']
);

$router->post(
    '/api/pontos',
    [CollectionPointController::class, 'store']
);

$router->put(
    '/api/pontos/{id}',
    [CollectionPointController::class, 'update']
);

$router->delete(
    '/api/pontos/{id}',
    [CollectionPointController::class, 'destroy']
);
