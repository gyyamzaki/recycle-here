<?php

declare(strict_types=1);

use App\Controllers\Web\AuthController;
use App\Controllers\Web\HomeController;
use App\Controllers\Web\PointController;
use App\Controllers\Web\CompanyPointController;
use App\Controllers\Web\AdminController;

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

$router->post(
    '/login',
    [AuthController::class, 'login']
);


$router->post(
    '/cadastro',
    [AuthController::class, 'register']
);


$router->post(
    '/logout',
    [AuthController::class, 'logout']
);

$router->get(
    '/empresa/pontos',
    [CompanyPointController::class, 'index']
);

$router->get(
    '/empresa/pontos',
    [
        CompanyPointController::class,
        'index'
    ]
);


$router->get(
    '/empresa/pontos/novo',
    [
        CompanyPointController::class,
        'create'
    ]
);


$router->post(
    '/empresa/pontos',
    [
        CompanyPointController::class,
        'store'
    ]
);

$router->get(
    '/empresa/pontos/{id}/editar',
    [
        CompanyPointController::class,
        'edit'
    ]
);


$router->post(
    '/empresa/pontos/{id}/editar',
    [
        CompanyPointController::class,
        'update'
    ]
);

$router->post(
    '/empresa/pontos/{id}/excluir',
    [
        CompanyPointController::class,
        'destroy'
    ]
);

/*
|--------------------------------------------------------------------------
| Administração
|--------------------------------------------------------------------------
*/

$router->get(
    '/admin',
    [
        AdminController::class,
        'index'
    ]
);


$router->get(
    '/admin/empresas',
    [
        AdminController::class,
        'companies'
    ]
);


$router->get(
    '/admin/empresas/{id}',
    [
        AdminController::class,
        'companyShow'
    ]
);


$router->post(
    '/admin/empresas/{id}/status',
    [
        AdminController::class,
        'companyStatus'
    ]
);


$router->get(
    '/admin/pontos',
    [
        AdminController::class,
        'points'
    ]
);


$router->get(
    '/admin/pontos/{id}',
    [
        AdminController::class,
        'pointShow'
    ]
);


$router->post(
    '/admin/pontos/{id}/status',
    [
        AdminController::class,
        'pointStatus'
    ]
);