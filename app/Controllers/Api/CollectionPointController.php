<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;
use App\Models\CollectionPoint;
use App\Models\Company;
use App\Middlewares\ApiAuthMiddleware;
use App\Middlewares\ApiCsrfMiddleware;
use App\Repositories\CompanyRepository;
use App\Services\CollectionPointService;
use App\Services\MaterialService;
use App\Validators\CollectionPointSearchValidator;
use App\Validators\CollectionPointValidator;

final class CollectionPointController
{
    private CompanyRepository $companyRepository;
    private CollectionPointService $pointService;
    private MaterialService $materialService;
    private CollectionPointSearchValidator $searchValidator;

    public function __construct()
    {
        $this->companyRepository =
            new CompanyRepository();

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
            $this->searchValidator
                ->validate(
                    $request->query()
                );

        if (!$validation['valid']) {
            Response::json(
                [
                    'error' => [
                        'status' => 400,
                        'message' =>
                            'Filtros de pesquisa inválidos.',
                        'details' =>
                            $validation['errors']
                    ]
                ],
                400
            );
        }

        $filters =
            $validation['data'];

        $points =
            $this->pointService
                ->searchActive(
                    $filters['bairro'],
                    $filters['material']
                );

        $data =
            array_map(
                fn (CollectionPoint $point): array =>
                    $this->pointToArray(
                        $point
                    ),
                $points
            );

        Response::json(
            [
                'data' => $data,
                'meta' => [
                    'count' => count($data),
                    'filters' => $filters
                ]
            ]
        );
    }

    public function show(
        Request $request,
        string $id
    ): void {

        $pointId =
            $this->parseId($id);

        if ($pointId === null) {
            $this->notFound();
        }

        $point =
            $this->pointService
                ->findActiveById(
                    $pointId
                );

        if ($point === null) {
            $this->notFound();
        }

        Response::json(
            [
                'data' =>
                    $this->pointToArray(
                        $point
                    )
            ]
        );
    }

    public function store(
        Request $request
    ): void {

        $company =
            $this->currentCompany();

        ApiCsrfMiddleware::handle(
            $request
        );

        $this->validateJson($request);

        $validation =
            CollectionPointValidator::validate(
                $request->input(),
                $this->validMaterialIds()
            );

        if (!empty($validation['errors'])) {
            $this->validationError(
                $validation['errors']
            );
        }

        $pointId =
            $this->pointService
                ->createForCompany(
                    $company->id,
                    $validation['data']
                );

        $point =
            $this->pointService
                ->findActiveById(
                    $pointId
                );

        Response::json(
            [
                'data' =>
                    $point !== null
                        ? $this->pointToArray($point)
                        : ['id' => $pointId]
            ],
            201
        );
    }

    public function update(
        Request $request,
        string $id
    ): void {

        $company =
            $this->currentCompany();

        ApiCsrfMiddleware::handle(
            $request
        );

        $this->validateJson($request);

        $pointId =
            $this->parseId($id);

        if ($pointId === null) {
            $this->notFound();
        }

        $existingPoint =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );

        if ($existingPoint === null) {
            $this->notFound();
        }

        $validation =
            CollectionPointValidator::validate(
                $request->input(),
                $this->validMaterialIds()
            );

        if (!empty($validation['errors'])) {
            $this->validationError(
                $validation['errors']
            );
        }

        $this->pointService
            ->updateForCompany(
                $pointId,
                $company->id,
                $validation['data']
            );

        $updatedPoint =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );

        Response::json(
            [
                'data' =>
                    $updatedPoint !== null
                        ? $this->pointToArray(
                            $updatedPoint
                        )
                        : ['id' => $pointId]
            ]
        );
    }

    public function destroy(
        Request $request,
        string $id
    ): void {

        $company =
            $this->currentCompany();

        ApiCsrfMiddleware::handle(
            $request
        );

        $pointId =
            $this->parseId($id);

        if ($pointId === null) {
            $this->notFound();
        }

        $point =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );

        if ($point === null) {
            $this->notFound();
        }

        $deleted =
            $this->pointService
                ->deleteForCompany(
                    $pointId,
                    $company->id
                );

        if (!$deleted) {
            $this->notFound();
        }

        Response::json(
            [
                'data' => [
                    'id' => $pointId,
                    'deleted' => true,
                    'message' =>
                        'Ponto de coleta excluído com sucesso.'
                ]
            ]
        );
    }

    private function currentCompany(): Company
    {
        $user =
            ApiAuthMiddleware::role(
                'company'
            );

        $company =
            $this->companyRepository
                ->findByUserId(
                    (int) $user['id']
                );

        if (
            $company === null
            ||
            !$company->active
        ) {
            Response::json(
                [
                    'error' => [
                        'status' => 403,
                        'message' =>
                            'A empresa associada a este usuário está inativa ou não existe.'
                    ]
                ],
                403
            );
        }

        return $company;
    }

    private function validMaterialIds(): array
    {
        return array_map(
            static fn ($material): int =>
                (int) $material->id,
            $this->materialService
                ->listActive()
        );
    }

    private function validateJson(
        Request $request
    ): void {

        if ($request->hasInvalidJson()) {
            Response::json(
                [
                    'error' => [
                        'status' => 400,
                        'message' =>
                            'O corpo da requisição contém JSON inválido.'
                    ]
                ],
                400
            );
        }
    }

    private function parseId(
        string $id
    ): ?int {

        if (
            !ctype_digit($id)
            ||
            (int) $id <= 0
        ) {
            return null;
        }

        return (int) $id;
    }

    private function validationError(
        array $errors
    ): never {

        Response::json(
            [
                'error' => [
                    'status' => 400,
                    'message' =>
                        'Os dados enviados são inválidos.',
                    'details' =>
                        $errors
                ]
            ],
            400
        );
    }

    private function notFound(): never
    {
        Response::json(
            [
                'error' => [
                    'status' => 404,
                    'message' =>
                        'Ponto de coleta não encontrado.'
                ]
            ],
            404
        );
    }

    private function pointToArray(
        CollectionPoint $point
    ): array {

        $materials = [];

        foreach (
            $point->materials
            as $index => $name
        ) {
            $materials[] = [
                'name' => $name,
                'slug' =>
                    $point->materialSlugs[$index]
                    ??
                    null
            ];
        }

        return [
            'id' => $point->id,
            'name' => $point->name,
            'company' => [
                'id' => $point->companyId,
                'name' => $point->companyName
            ],
            'address' => [
                'street' => $point->street,
                'number' => $point->number,
                'complement' => $point->complement,
                'neighborhood' => $point->neighborhood,
                'city' => $point->city,
                'state' => $point->state,
                'zip_code' => $point->zipCode
            ],
            'phone' => $point->phone,
            'opening_hours' =>
                $point->openingHours,
            'materials' => $materials
        ];
    }
}
