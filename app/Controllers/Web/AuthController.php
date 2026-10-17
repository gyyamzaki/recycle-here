<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
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

            echo 'Requisição inválida.';

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

            Response::status(401);

            $errors['login'] =
                'E-mail ou senha inválidos.';


            require dirname(__DIR__, 2)
                . '/Views/auth/login.php';

            return;
        }


        Response::redirect(
            '/empresa/pontos'
        );
    }


    public function registerForm(
        Request $request
    ): void {

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

            echo 'Requisição inválida.';

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

            echo 'Requisição inválida.';

            return;
        }


        $this->authService
            ->logout();


        Response::redirect(
            '/'
        );
    }
}