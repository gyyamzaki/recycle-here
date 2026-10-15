<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Core\Response;
use App\Services\CollectionPointService;

final class PointController
{
    private CollectionPointService $service;


    public function __construct()
    {
        $this->service =
            new CollectionPointService();
    }


    public function index(
        Request $request
    ): void {

        $points =
            $this->service->listActive();


        require dirname(__DIR__, 2)
            . '/Views/points/index.php';
    }


    public function show(
        Request $request,
        string $id
    ): void {

        if (
            !ctype_digit($id) ||
            (int) $id <= 0
        ) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        $point =
            $this->service
                ->findActiveById((int) $id);


        if ($point === null) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        require dirname(__DIR__, 2)
            . '/Views/points/show.php';
    }
}