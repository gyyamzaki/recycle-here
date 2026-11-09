<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CollectionPoint;
use App\Repositories\CollectionPointRepository;
use App\Core\Logger;

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

    public function listByCompany(
        int $companyId
    ): array {

        return $this->repository
            ->findByCompanyId(
                $companyId
            );
    }

    public function createForCompany(
        int $companyId,
        array $data
    ): int {

        $pointId =
            $this->repository
                ->createWithMaterials(
                    $companyId,
                    $data
                );


        Logger::info(
            'collection_point_created',
            [
                'point_id' =>
                    $pointId,

                'company_id' =>
                    $companyId,

                'point_name' =>
                    $data['name']
                    ??
                    null
            ]
        );


        return $pointId;
    }

    public function findForCompany(
        int $pointId,
        int $companyId
    ): ?\App\Models\CollectionPoint {

        $point =
            $this->repository
                ->findActiveById($pointId);


        if (
            $point === null
            ||
            $point->companyId !== $companyId
        ) {
            return null;
        }


        return $point;
    }


    public function updateForCompany(
        int $pointId,
        int $companyId,
        array $data
    ): void {

        $this->repository
            ->updateWithMaterials(
                $pointId,
                $companyId,
                $data
            );
    }

    /**
     * Solicita a exclusão de um ponto
     * pertencente à empresa autenticada.
     */
    public function deleteForCompany(
        int $pointId,
        int $companyId
    ): bool {

        return $this->repository
            ->deleteForCompany(
                $pointId,
                $companyId
            );
    }
}