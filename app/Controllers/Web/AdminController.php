<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;

use App\Repositories\AdminRepository;


final class AdminController
{
    private AdminRepository $repository;


    public function __construct()
    {
        $this->repository =
            new AdminRepository();
    }


    /**
     * Dashboard.
     */
    public function index(
        Request $request
    ): void {

        $this->authorize();


        $user =
            Session::get('user');


        $stats =
            $this->repository
                ->dashboardStats();


        $companies =
            array_slice(
                $this->repository
                    ->listCompanies(),
                0,
                5
            );


        $points =
            array_slice(
                $this->repository
                    ->listPoints(),
                0,
                5
            );


        require dirname(__DIR__, 2)
            . '/Views/admin/index.php';
    }


    /**
     * Lista todas as empresas.
     */
    public function companies(
        Request $request
    ): void {

        $this->authorize();


        $companies =
            $this->repository
                ->listCompanies();


        require dirname(__DIR__, 2)
            . '/Views/admin/companies/index.php';
    }


    /**
     * Detalhes de uma empresa.
     */
    public function companyShow(
        Request $request,
        string $id
    ): void {

        $this->authorize();


        $companyId =
            $this->parseId($id);


        if ($companyId === null) {

            $this->notFound();

            return;
        }


        $company =
            $this->repository
                ->findCompanyById(
                    $companyId
                );


        if ($company === null) {

            $this->notFound();

            return;
        }


        $points =
            $this->repository
                ->listPointsByCompany(
                    $companyId
                );


        require dirname(__DIR__, 2)
            . '/Views/admin/companies/show.php';
    }


    /**
     * Ativa/desativa uma empresa.
     */
    public function companyStatus(
        Request $request,
        string $id
    ): void {

        $this->authorize();


        $companyId =
            $this->parseId($id);


        if ($companyId === null) {

            $this->notFound();

            return;
        }


        if (
            !Csrf::validate(
                $request->input('_csrf')
            )
        ) {

            $this->forbidden();

            return;
        }


        $activeInput =
            (string) $request->input(
                'active',
                ''
            );


        if (
            $activeInput !== '0'
            &&
            $activeInput !== '1'
        ) {

            Response::status(400);

            echo 'Status inválido.';

            return;
        }


        $updated =
            $this->repository
                ->setCompanyActive(
                    $companyId,
                    $activeInput === '1'
                );


        if (!$updated) {

            $this->notFound();

            return;
        }


        Response::redirect(
            '/admin/empresas/'
            . $companyId
        );
    }


    /**
     * Lista todos os pontos.
     */
    public function points(
        Request $request
    ): void {

        $this->authorize();


        $points =
            $this->repository
                ->listPoints();


        require dirname(__DIR__, 2)
            . '/Views/admin/points/index.php';
    }


    /**
     * Detalhes de um ponto.
     */
    public function pointShow(
        Request $request,
        string $id
    ): void {

        $this->authorize();


        $pointId =
            $this->parseId($id);


        if ($pointId === null) {

            $this->notFound();

            return;
        }


        $point =
            $this->repository
                ->findPointById(
                    $pointId
                );


        if ($point === null) {

            $this->notFound();

            return;
        }


        require dirname(__DIR__, 2)
            . '/Views/admin/points/show.php';
    }


    /**
     * Ativa/desativa um ponto.
     */
    public function pointStatus(
        Request $request,
        string $id
    ): void {

        $this->authorize();


        $pointId =
            $this->parseId($id);


        if ($pointId === null) {

            $this->notFound();

            return;
        }


        if (
            !Csrf::validate(
                $request->input('_csrf')
            )
        ) {

            $this->forbidden();

            return;
        }


        $activeInput =
            (string) $request->input(
                'active',
                ''
            );


        if (
            $activeInput !== '0'
            &&
            $activeInput !== '1'
        ) {

            Response::status(400);

            echo 'Status inválido.';

            return;
        }


        $updated =
            $this->repository
                ->setPointActive(
                    $pointId,
                    $activeInput === '1'
                );


        if (!$updated) {

            Response::status(409);

            echo 'Não foi possível alterar o status do ponto. '
                . 'Verifique se a empresa responsável está ativa.';

            return;
        }


        Response::redirect(
            '/admin/pontos/'
            . $pointId
        );
    }


    /**
     * Proteção comum da área administrativa.
     */
    private function authorize(): void
    {
        AuthMiddleware::handle();

        RoleMiddleware::handle(
            'admin'
        );
    }


    /**
     * Valida IDs vindos da URL.
     */
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


    private function notFound(): void
    {
        Response::status(404);

        require dirname(__DIR__, 2)
            . '/Views/errors/404.php';
    }


    private function forbidden(): void
    {
        Response::status(403);

        require dirname(__DIR__, 2)
            . '/Views/errors/403.php';
    }
}