<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;

final class ApiCsrfMiddleware
{
    public static function handle(
        Request $request
    ): void {

        $token =
            $request->header(
                'X-CSRF-Token'
            );

        if (
            !is_string($token)
            ||
            $token === ''
        ) {
            $token =
                $request->input(
                    '_csrf',
                    ''
                );
        }

        if (
            !is_string($token)
            ||
            !Csrf::validate($token)
        ) {
            Response::json(
                [
                    'error' => [
                        'status' => 403,
                        'message' =>
                            'Token CSRF inválido ou ausente.'
                    ]
                ],
                403
            );
        }
    }
}
