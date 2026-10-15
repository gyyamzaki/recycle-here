<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;

final class AuthController
{
    public function loginForm(Request $request): void
    {
        require dirname(__DIR__, 2)
            . '/Views/auth/login.php';
    }


    public function registerForm(Request $request): void
    {
        require dirname(__DIR__, 2)
            . '/Views/auth/register.php';
    }
}
