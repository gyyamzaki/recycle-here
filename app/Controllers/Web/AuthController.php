<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Csrf;
use App\Core\Logger;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
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


    public function loginForm(
        Request $request
    ): void {

        if (
            $this->redirectAuthenticatedUser()
        ) {

            return;
        }


        $errors = [];


        require dirname(__DIR__, 2)
            . '/Views/auth/login.php';
    }


    public function login(
        Request $request
    ): void {

        if (
            !Csrf::validate(
                $request->input('_csrf')
            )
        ) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        $validation =
            $this->validator
                ->validateLogin(
                    $request->input()
                );


        $errors =
            $validation['errors'];


        if (!$validation['valid']) {

            Response::status(400);

            require dirname(__DIR__, 2)
                . '/Views/auth/login.php';

            return;
        }


        $data =
            $validation['data'];


        if (
            !$this->authService->login(
                $data['email'],
                $data['password']
            )
        ) {

            /*
             * Log de tentativa de login
             * com credenciais inválidas.
             */
            Logger::warning(
                'login_failed',
                [
                    'email' =>
                        $data['email']
                ]
            );


            Response::status(401);


            $errors['login'] =
                'E-mail ou senha inválidos.';


            require dirname(__DIR__, 2)
                . '/Views/auth/login.php';

            return;
        }


        /*
         * Usuário que acabou de ser
         * autenticado.
         */
        $user =
            Session::get('user');


        /*
         * Log de autenticação bem-sucedida.
         *
         * Senha nunca é registrada.
         */
        if (is_array($user)) {

            Logger::info(
                'login_success',
                [
                    'user_id' =>
                        $user['id']
                        ??
                        null,

                    'email' =>
                        $user['email']
                        ??
                        null,

                    'role' =>
                        $user['role']
                        ??
                        null
                ]
            );
        }


        /*
         * Admin vai para sua área.
         */
        if (
            is_array($user)
            &&
            ($user['role'] ?? null)
                ===
                'admin'
        ) {

            Response::redirect(
                '/admin'
            );

            return;
        }


        /*
         * Empresa vai para gerenciamento
         * dos próprios pontos.
         */
        Response::redirect(
            '/empresa/pontos'
        );
    }


    public function registerForm(
        Request $request
    ): void {

        if (
            $this->redirectAuthenticatedUser()
        ) {

            return;
        }


        $errors = [];


        require dirname(__DIR__, 2)
            . '/Views/auth/register.php';
    }


    public function register(
        Request $request
    ): void {

        if (
            !Csrf::validate(
                $request->input('_csrf')
            )
        ) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        $validation =
            $this->validator
                ->validateRegister(
                    $request->input()
                );


        $errors =
            $validation['errors'];


        if (!$validation['valid']) {

            Response::status(400);

            require dirname(__DIR__, 2)
                . '/Views/auth/register.php';

            return;
        }


        $result =
            $this->authService
                ->registerCompany(
                    $validation['data']
                );


        if (!$result['success']) {

            Response::status(409);

            $errors =
                $result['errors'];


            require dirname(__DIR__, 2)
                . '/Views/auth/register.php';

            return;
        }


        Response::redirect(
            '/login'
        );
    }


    public function logout(
        Request $request
    ): void {

        if (
            !Csrf::validate(
                $request->input('_csrf')
            )
        ) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        $this->authService
            ->logout();


        Response::redirect(
            '/'
        );
    }


    private function redirectAuthenticatedUser(): bool
    {
        $user =
            Session::get('user');


        if (!is_array($user)) {

            return false;
        }


        $role =
            $user['role']
            ??
            null;


        if ($role === 'admin') {

            Response::redirect(
                '/admin'
            );

            return true;
        }


        if ($role === 'company') {

            Response::redirect(
                '/empresa/pontos'
            );

            return true;
        }


        return false;
    }
}