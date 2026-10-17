<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;

final class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Session::has('user')) {

            Response::redirect('/login');
        }
    }
}