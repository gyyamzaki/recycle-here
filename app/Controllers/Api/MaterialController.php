<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;
use App\Services\MaterialService;

final class MaterialController
{
    private MaterialService $materialService;

    public function __construct()
    {
        $this->materialService =
            new MaterialService();
    }

    public function index(
        Request $request
    ): void {

        $materials =
            $this->materialService
                ->listActive();

        $data =
            array_map(
                static fn ($material): array => [
                    'id' =>
                        (int) $material->id,
                    'name' =>
                        $material->name,
                    'slug' =>
                        $material->slug
                ],
                $materials
            );

        Response::json(
            [
                'data' => $data,
                'meta' => [
                    'count' => count($data)
                ]
            ]
        );
    }
}
