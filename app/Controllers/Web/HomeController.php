<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;

final class HomeController
{
    public function index(Request $request): void
    {
        require dirname(__DIR__, 2)
            . '/Views/home/index.php';
    }
}
