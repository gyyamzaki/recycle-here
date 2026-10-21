<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Core\Session;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;

final class AdminController
{
    public function index(
        Request $request
    ): void {

        /*
         * Precisa estar autenticado.
         */
        AuthMiddleware::handle();


        /*
         * Precisa possuir perfil admin.
         */
        RoleMiddleware::handle(
            'admin'
        );


        $user =
            Session::get('user');


        require dirname(__DIR__, 2)
            . '/Views/admin/index.php';
    }
}