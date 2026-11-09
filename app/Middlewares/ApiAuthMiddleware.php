<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;

final class ApiAuthMiddleware
{
    public static function authenticated(): array
    {
        $user =
            Session::get('user');

        if (!is_array($user)) {
            Response::json(
                [
                    'error' => [
                        'status' => 401,
                        'message' =>
                            'Autenticação necessária.'
                    ]
                ],
                401
            );
        }

        return $user;
    }

    public static function role(
        string $requiredRole
    ): array {

        $user =
            self::authenticated();

        if (
            ($user['role'] ?? null)
            !==
            $requiredRole
        ) {
            Response::json(
                [
                    'error' => [
                        'status' => 403,
                        'message' =>
                            'Você não possui permissão para acessar este recurso.'
                    ]
                ],
                403
            );
        }

        return $user;
    }
}
