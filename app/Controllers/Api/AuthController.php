<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Csrf;
use App\Core\Logger;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Middlewares\ApiAuthMiddleware;
use App\Middlewares\ApiCsrfMiddleware;
use App\Services\AuthService;
use App\Validators\AuthValidator;

final class AuthController
{
    private AuthService $authService;
    private AuthValidator $validator;

    public function __construct()
    {
        $this->authService =
            new AuthService();

        $this->validator =
            new AuthValidator();
    }

    public function login(
        Request $request
    ): void {

        if ($request->hasInvalidJson()) {
            Response::json(
                [
                    'error' => [
                        'status' => 400,
                        'message' =>
                            'O corpo da requisição contém JSON inválido.'
                    ]
                ],
                400
            );
        }

        $validation =
            $this->validator
                ->validateLogin(
                    $request->input()
                );

        if (!$validation['valid']) {
            Response::json(
                [
                    'error' => [
                        'status' => 400,
                        'message' =>
                            'Dados de autenticação inválidos.',
                        'details' =>
                            $validation['errors']
                    ]
                ],
                400
            );
        }

        $data =
            $validation['data'];

        if (
            !$this->authService
                ->login(
                    $data['email'],
                    $data['password']
                )
        ) {
            Logger::warning(
                'login_failed',
                [
                    'email' =>
                        $data['email'],
                    'source' =>
                        'api'
                ]
            );

            Response::json(
                [
                    'error' => [
                        'status' => 401,
                        'message' =>
                            'E-mail ou senha inválidos.'
                    ]
                ],
                401
            );
        }

        $user =
            Session::get('user');

        if (is_array($user)) {
            Logger::info(
                'login_success',
                [
                    'user_id' =>
                        $user['id'] ?? null,
                    'email' =>
                        $user['email'] ?? null,
                    'role' =>
                        $user['role'] ?? null,
                    'source' =>
                        'api'
                ]
            );
        }

        Response::json(
            [
                'data' => [
                    'user' =>
                        $this->publicUser(
                            $user
                        ),
                    'csrf_token' =>
                        Csrf::token()
                ]
            ]
        );
    }

    public function me(
        Request $request
    ): void {

        $user =
            ApiAuthMiddleware::authenticated();

        Response::json(
            [
                'data' => [
                    'user' =>
                        $this->publicUser(
                            $user
                        ),
                    'csrf_token' =>
                        Csrf::token()
                ]
            ]
        );
    }

    public function logout(
        Request $request
    ): void {

        ApiAuthMiddleware::authenticated();

        ApiCsrfMiddleware::handle(
            $request
        );

        $this->authService
            ->logout();

        Response::json(
            [
                'data' => [
                    'message' =>
                        'Sessão encerrada com sucesso.'
                ]
            ]
        );
    }

    private function publicUser(
        mixed $user
    ): array {

        if (!is_array($user)) {
            return [];
        }

        return [
            'id' =>
                (int) ($user['id'] ?? 0),
            'name' =>
                (string) ($user['name'] ?? ''),
            'email' =>
                (string) ($user['email'] ?? ''),
            'role' =>
                (string) ($user['role'] ?? '')
        ];
    }
}
