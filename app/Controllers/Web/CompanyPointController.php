<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

use App\Models\Company;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;

use App\Repositories\CompanyRepository;

use App\Services\CollectionPointService;
use App\Services\MaterialService;

use App\Validators\CollectionPointValidator;


final class CompanyPointController
{
    private CompanyRepository $companyRepository;

    private CollectionPointService $pointService;

    private MaterialService $materialService;


    public function __construct()
    {
        $this->companyRepository =
            new CompanyRepository();


        $this->pointService =
            new CollectionPointService();


        $this->materialService =
            new MaterialService();
    }


    /**
     * Lista os pontos pertencentes
     * à empresa autenticada.
     */
    public function index(
        Request $request
    ): void {

        $company =
            $this->currentCompany();


        $points =
            $this->pointService
                ->listByCompany(
                    $company->id
                );


        require dirname(__DIR__, 2)
            . '/Views/company/points/index.php';
    }


    /**
     * Exibe o formulário para
     * cadastrar um novo ponto.
     */
    public function create(
        Request $request
    ): void {

        $company =
            $this->currentCompany();


        $materials =
            $this->materialService
                ->listActive();


        $errors = [];


        $old = [

            'name' => '',

            'street' => '',

            'number' => '',

            'complement' => '',

            'neighborhood' => '',

            'city' => 'Sorocaba',

            'state' => 'SP',

            'zip_code' => '',

            'phone' => '',

            'opening_hours' => '',

            'materials' => []
        ];


        require dirname(__DIR__, 2)
            . '/Views/company/points/create.php';
    }


    /**
     * Valida e cadastra
     * um novo ponto.
     */
    public function store(
        Request $request
    ): void {

        $company =
            $this->currentCompany();


        /*
         * Proteção CSRF.
         */
        $csrf =
            (string) $request->input(
                '_csrf',
                ''
            );


        if (!Csrf::validate($csrf)) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        /*
         * Busca materiais válidos no banco.
         */
        $materials =
            $this->materialService
                ->listActive();


        $validMaterialIds =
            array_map(
                static fn ($material): int =>
                    (int) $material->id,
                $materials
            );


        /*
         * Validação de todos os dados externos.
         */
        $result =
            CollectionPointValidator::validate(
                $request->input(),
                $validMaterialIds
            );


        $data =
            $result['data'];


        $errors =
            $result['errors'];


        /*
         * Retorna ao formulário em caso
         * de dados inválidos.
         */
        if (!empty($errors)) {

            Response::status(400);


            $old =
                $data;


            require dirname(__DIR__, 2)
                . '/Views/company/points/create.php';

            return;
        }


        /*
         * O company_id NÃO vem do formulário.
         * É obtido através da empresa autenticada.
         */
        $this->pointService
            ->createForCompany(
                $company->id,
                $data
            );


        /*
         * POST -> Redirect -> GET
         */
        Response::redirect(
            '/empresa/pontos'
        );
    }


    /**
     * Exibe o formulário de edição.
     */
    public function edit(
        Request $request,
        string $id
    ): void {

        $company =
            $this->currentCompany();


        /*
         * Valida o ID recebido pela URL.
         */
        if (
            !ctype_digit($id)
            ||
            (int) $id <= 0
        ) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        $pointId =
            (int) $id;


        /*
         * Busca o ponto somente se ele
         * pertencer à empresa autenticada.
         */
        $point =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );


        if ($point === null) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        $materials =
            $this->materialService
                ->listActive();


        /*
         * Descobre quais materiais do ponto
         * devem aparecer marcados.
         */
        $selectedMaterials = [];


        foreach ($materials as $material) {

            if (
                in_array(
                    $material->slug,
                    $point->materialSlugs,
                    true
                )
            ) {

                $selectedMaterials[] =
                    (int) $material->id;
            }
        }


        $errors = [];


        $old = [

            'name' =>
                $point->name,

            'street' =>
                $point->street,

            'number' =>
                $point->number,

            'complement' =>
                $point->complement ?? '',

            'neighborhood' =>
                $point->neighborhood,

            'city' =>
                $point->city,

            'state' =>
                $point->state,

            'zip_code' =>
                $point->zipCode ?? '',

            'phone' =>
                $point->phone ?? '',

            'opening_hours' =>
                $point->openingHours,

            'materials' =>
                $selectedMaterials
        ];


        require dirname(__DIR__, 2)
            . '/Views/company/points/edit.php';
    }


    /**
     * Valida e atualiza um ponto.
     */
    public function update(
        Request $request,
        string $id
    ): void {

        $company =
            $this->currentCompany();


        if (
            !ctype_digit($id)
            ||
            (int) $id <= 0
        ) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        $pointId =
            (int) $id;


        /*
         * Confirma que o ponto pertence
         * à empresa autenticada.
         */
        $point =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );


        if ($point === null) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        /*
         * Proteção CSRF.
         */
        $csrf =
            (string) $request->input(
                '_csrf',
                ''
            );


        if (!Csrf::validate($csrf)) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        /*
         * Materiais permitidos.
         */
        $materials =
            $this->materialService
                ->listActive();


        $validMaterialIds =
            array_map(
                static fn ($material): int =>
                    (int) $material->id,
                $materials
            );


        /*
         * Reutiliza exatamente a mesma
         * validação utilizada no CREATE.
         */
        $result =
            CollectionPointValidator::validate(
                $request->input(),
                $validMaterialIds
            );


        $data =
            $result['data'];


        $errors =
            $result['errors'];


        if (!empty($errors)) {

            Response::status(400);


            $old =
                $data;


            require dirname(__DIR__, 2)
                . '/Views/company/points/edit.php';

            return;
        }


        $this->pointService
            ->updateForCompany(
                $pointId,
                $company->id,
                $data
            );


        Response::redirect(
            '/empresa/pontos'
        );
    }


    /**
     * Exclui um ponto pertencente
     * à empresa autenticada.
     */
    public function destroy(
        Request $request,
        string $id
    ): void {

        $company =
            $this->currentCompany();


        /*
         * Validação do ID recebido pela URL.
         */
        if (
            !ctype_digit($id)
            ||
            (int) $id <= 0
        ) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        $pointId =
            (int) $id;


        /*
         * Proteção contra CSRF.
         */
        $csrf =
            (string) $request->input(
                '_csrf',
                ''
            );


        if (!Csrf::validate($csrf)) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        /*
         * Confirma que o ponto existe
         * e pertence à empresa atual.
         */
        $point =
            $this->pointService
                ->findForCompany(
                    $pointId,
                    $company->id
                );


        if ($point === null) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        /*
         * Repository também verifica
         * o company_id durante o DELETE.
         */
        $deleted =
            $this->pointService
                ->deleteForCompany(
                    $pointId,
                    $company->id
                );


        if (!$deleted) {

            Response::status(404);

            require dirname(__DIR__, 2)
                . '/Views/errors/404.php';

            return;
        }


        Response::redirect(
            '/empresa/pontos'
        );
    }


    /**
     * Retorna a empresa associada
     * ao usuário autenticado.
     *
     * O company_id nunca é recebido
     * diretamente do navegador.
     */
    private function currentCompany(): Company
    {
        AuthMiddleware::handle();


        RoleMiddleware::handle(
            'company'
        );


        $user =
            Session::get('user');


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

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            exit;
        }


        return $company;
    }
}