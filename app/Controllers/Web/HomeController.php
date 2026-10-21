<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Request;
use App\Core\Session;
use App\Services\CollectionPointService;
use App\Services\MaterialService;

final class HomeController
{
    private CollectionPointService $pointService;
    private MaterialService $materialService;


    public function __construct()
    {
        $this->pointService =
            new CollectionPointService();

        $this->materialService =
            new MaterialService();
    }


    public function index(
        Request $request
    ): void {

        /*
         * Busca os materiais ativos
         * para o formulário de pesquisa.
         */
        $materials =
            $this->materialService
                ->listActive();


        /*
         * Mostra até três pontos de coleta
         * na página inicial.
         */
        $featuredPoints =
            array_slice(
                $this->pointService
                    ->searchActive(),
                0,
                3
            );


        /*
         * Verifica se existe usuário
         * autenticado na sessão.
         */
        $user =
            Session::get('user');


        /*
         * Empresa autenticada.
         */
        $isCompanyLogged =
            is_array($user)
            &&
            ($user['role'] ?? null) === 'company';


        /*
         * Administrador autenticado.
         */
        $isAdminLogged =
            is_array($user)
            &&
            ($user['role'] ?? null) === 'admin';


        require dirname(__DIR__, 2)
            . '/Views/home/index.php';
    }
}