<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Services\CollectionPointService;
use App\Services\MaterialService;

final class HomeController
{
    private CollectionPointService $pointService;
    private MaterialService $materialService;

    public function __construct()
    {
        $this->pointService = new CollectionPointService();
        $this->materialService = new MaterialService();
    }

    public function index(Request $request): void
    {
        $materials = $this->materialService->listActive();

        $featuredPoints = array_slice(
            $this->pointService->searchActive(),
            0,
            3
        );

        require dirname(__DIR__, 2) . '/Views/home/index.php';
    }
}
