<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;

final class RoleMiddleware
{
    public static function handle(
        string $requiredRole
    ): void {

        $user =
            Session::get('user');


        if (
            !is_array($user) ||
            ($user['role'] ?? null) !==
            $requiredRole
        ) {

            Response::status(403);

            require dirname(__DIR__)
                . '/Views/errors/403.php';

            exit;
        }
    }
}