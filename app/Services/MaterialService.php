<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\MaterialRepository;

final class MaterialService
{
    private MaterialRepository $repository;


    public function __construct(
        ?MaterialRepository $repository = null
    ) {
        $this->repository =
            $repository ??
            new MaterialRepository();
    }


    public function listActive(): array
    {
        return $this->repository->allActive();
    }
}