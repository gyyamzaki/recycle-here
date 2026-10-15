<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Core\Response;
use App\Services\CollectionPointService;
use App\Services\MaterialService;
use App\Validators\CollectionPointSearchValidator;

final class PointController
{
    private CollectionPointService $pointService;
    private MaterialService $materialService;
    private CollectionPointSearchValidator $searchValidator;


    public function __construct()
    {
        $this->pointService =
            new CollectionPointService();

        $this->materialService =
            new MaterialService();

        $this->searchValidator =
            new CollectionPointSearchValidator();
    }


    public function index(
        Request $request
    ): void {

        $validation =
            $this->searchValidator->validate(
                $request->query()
            );


        $filters =
            $validation['data'];

        $errors =
            $validation['errors'];


        $materials =
            $this->materialService
                ->listActive();


        if (!$validation['valid']) {

            Response::status(400);

            $points = [];

        } else {

            $points =
                $this->pointService
                    ->searchActive(
                        $filters['bairro'],
                        $filters['material']
                    );
        }


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
            $this->pointService
                ->findActiveById(
                    (int) $id
                );


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