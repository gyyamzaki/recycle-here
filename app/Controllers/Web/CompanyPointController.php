<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;
use App\Repositories\CompanyRepository;
use App\Services\CollectionPointService;

final class CompanyPointController
{
    private CompanyRepository
        $companyRepository;

    private CollectionPointService
        $pointService;


    public function __construct()
    {
        $this->companyRepository =
            new CompanyRepository();

        $this->pointService =
            new CollectionPointService();
    }


    public function index(
        Request $request
    ): void {

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
            $company === null ||
            !$company->active
        ) {

            Response::status(403);

            require dirname(__DIR__, 2)
                . '/Views/errors/403.php';

            return;
        }


        $points =
            $this->pointService
                ->listByCompany(
                    $company->id
                );


        require dirname(__DIR__, 2)
            . '/Views/company/points/index.php';
    }
}