<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;

final class PointController
{
    public function index(Request $request): void
    {
        require dirname(__DIR__, 2)
            . '/Views/points/index.php';
    }


    public function show(
        Request $request,
        string $id
    ): void {
        require dirname(__DIR__, 2)
            . '/Views/points/show.php';
    }
}