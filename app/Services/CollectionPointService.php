<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CollectionPoint;
use App\Repositories\CollectionPointRepository;

final class CollectionPointService
{
    private CollectionPointRepository $repository;


    public function __construct(
        ?CollectionPointRepository $repository = null
    ) {
        $this->repository =
            $repository ??
            new CollectionPointRepository();
    }


    public function searchActive(
        string $neighborhood = '',
        string $materialSlug = ''
    ): array {

        return $this->repository
            ->searchActive(
                $neighborhood,
                $materialSlug
            );
    }


    public function findActiveById(
        int $id
    ): ?CollectionPoint {

        return $this->repository
            ->findActiveById($id);
    }
}