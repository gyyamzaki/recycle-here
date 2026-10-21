<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;
use RuntimeException;
use Throwable;

final class AdminRepository
{
    private PDO $connection;


    public function __construct()
    {
        $this->connection =
            Database::connection();
    }


    /**
     * Dados gerais apresentados no dashboard.
     */
    public function dashboardStats(): array
    {
        $sql = '
            SELECT
                (
                    SELECT COUNT(*)
                    FROM companies
                ) AS total_companies,

                (
                    SELECT COUNT(*)
                    FROM companies
                    WHERE active = 1
                ) AS active_companies,

                (
                    SELECT COUNT(*)
                    FROM companies
                    WHERE active = 0
                ) AS inactive_companies,

                (
                    SELECT COUNT(*)
                    FROM collection_points
                ) AS total_points,

                (
                    SELECT COUNT(*)
                    FROM collection_points
                    WHERE active = 1
                ) AS active_points,

                (
                    SELECT COUNT(*)
                    FROM collection_points
                    WHERE active = 0
                ) AS inactive_points
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute();


        $stats =
            $statement->fetch(PDO::FETCH_ASSOC);


        return $stats ?: [];
    }


    /**
     * Lista todas as empresas.
     */
    public function listCompanies(): array
    {
        $sql = '
            SELECT
                c.id,
                c.user_id,
                c.name,
                c.cnpj,
                c.phone,
                c.active,
                c.created_at,
                c.updated_at,

                u.email,
                u.active AS user_active,

                COUNT(cp.id) AS point_count,

                COALESCE(
                    SUM(cp.active = 1),
                    0
                ) AS active_point_count

            FROM companies AS c

            INNER JOIN users AS u
                ON u.id = c.user_id

            LEFT JOIN collection_points AS cp
                ON cp.company_id = c.id

            GROUP BY
                c.id,
                c.user_id,
                c.name,
                c.cnpj,
                c.phone,
                c.active,
                c.created_at,
                c.updated_at,
                u.email,
                u.active

            ORDER BY
                c.name ASC
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute();


        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Retorna uma empresa específica.
     */
    public function findCompanyById(
        int $companyId
    ): ?array {

        $sql = '
            SELECT
                c.id,
                c.user_id,
                c.name,
                c.cnpj,
                c.phone,
                c.active,
                c.created_at,
                c.updated_at,

                u.name AS user_name,
                u.email,
                u.active AS user_active,

                (
                    SELECT COUNT(*)
                    FROM collection_points
                    WHERE company_id = c.id
                ) AS point_count,

                (
                    SELECT COUNT(*)
                    FROM collection_points
                    WHERE
                        company_id = c.id
                        AND active = 1
                ) AS active_point_count

            FROM companies AS c

            INNER JOIN users AS u
                ON u.id = c.user_id

            WHERE c.id = :id

            LIMIT 1
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute([
            'id' => $companyId
        ]);


        $company =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $company ?: null;
    }


    /**
     * Pontos pertencentes a uma empresa.
     */
    public function listPointsByCompany(
        int $companyId
    ): array {

        $sql = '
            SELECT
                cp.id,
                cp.name,
                cp.neighborhood,
                cp.city,
                cp.state,
                cp.active

            FROM collection_points AS cp

            WHERE cp.company_id = :company_id

            ORDER BY
                cp.name ASC
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute([
            'company_id' => $companyId
        ]);


        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Lista todos os pontos de todas as empresas.
     */
    public function listPoints(): array
    {
        $sql = '
            SELECT
                cp.id,
                cp.company_id,
                cp.name,
                cp.neighborhood,
                cp.city,
                cp.state,
                cp.phone,
                cp.opening_hours,
                cp.active,
                cp.created_at,

                c.name AS company_name,
                c.active AS company_active

            FROM collection_points AS cp

            INNER JOIN companies AS c
                ON c.id = cp.company_id

            ORDER BY
                cp.name ASC
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute();


        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Retorna todas as informações de um ponto.
     */
    public function findPointById(
        int $pointId
    ): ?array {

        $sql = '
            SELECT
                cp.id,
                cp.company_id,
                cp.name,
                cp.street,
                cp.number,
                cp.complement,
                cp.neighborhood,
                cp.city,
                cp.state,
                cp.zip_code,
                cp.phone,
                cp.opening_hours,
                cp.active,
                cp.created_at,
                cp.updated_at,

                c.name AS company_name,
                c.active AS company_active,

                GROUP_CONCAT(
                    DISTINCT m.name
                    ORDER BY m.name
                    SEPARATOR ", "
                ) AS materials

            FROM collection_points AS cp

            INNER JOIN companies AS c
                ON c.id = cp.company_id

            LEFT JOIN collection_point_material AS cpm
                ON cpm.collection_point_id = cp.id

            LEFT JOIN materials AS m
                ON m.id = cpm.material_id

            WHERE cp.id = :id

            GROUP BY
                cp.id,
                cp.company_id,
                cp.name,
                cp.street,
                cp.number,
                cp.complement,
                cp.neighborhood,
                cp.city,
                cp.state,
                cp.zip_code,
                cp.phone,
                cp.opening_hours,
                cp.active,
                cp.created_at,
                cp.updated_at,
                c.name,
                c.active

            LIMIT 1
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute([
            'id' => $pointId
        ]);


        $point =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $point ?: null;
    }


    /**
     * Ativa ou desativa uma empresa.
     *
     * O usuário associado também recebe
     * o mesmo estado.
     *
     * Ao desativar a empresa, todos os pontos
     * também são desativados.
     */
    public function setCompanyActive(
        int $companyId,
        bool $active
    ): bool {

        try {

            $this->connection
                ->beginTransaction();


            $findStatement =
                $this->connection->prepare(
                    '
                        SELECT
                            id,
                            user_id

                        FROM companies

                        WHERE id = :id

                        LIMIT 1
                    '
                );


            $findStatement->execute([
                'id' => $companyId
            ]);


            $company =
                $findStatement->fetch(
                    PDO::FETCH_ASSOC
                );


            if (!$company) {

                $this->connection
                    ->rollBack();

                return false;
            }


            $companyStatement =
                $this->connection->prepare(
                    '
                        UPDATE companies

                        SET active = :active

                        WHERE id = :id
                    '
                );


            $companyStatement->execute([
                'active' => $active ? 1 : 0,
                'id' => $companyId
            ]);


            $userStatement =
                $this->connection->prepare(
                    '
                        UPDATE users

                        SET active = :active

                        WHERE id = :user_id
                    '
                );


            $userStatement->execute([
                'active' => $active ? 1 : 0,
                'user_id' => (int) $company['user_id']
            ]);


            /*
             * Ao desativar a empresa,
             * seus pontos também deixam
             * de aparecer publicamente.
             */
            if (!$active) {

                $pointsStatement =
                    $this->connection->prepare(
                        '
                            UPDATE collection_points

                            SET active = 0

                            WHERE company_id = :company_id
                        '
                    );


                $pointsStatement->execute([
                    'company_id' => $companyId
                ]);
            }


            $this->connection
                ->commit();


            return true;


        } catch (Throwable $exception) {

            if (
                $this->connection
                    ->inTransaction()
            ) {

                $this->connection
                    ->rollBack();
            }


            throw new RuntimeException(
                'Não foi possível atualizar o status da empresa.',
                0,
                $exception
            );
        }
    }


    /**
     * Ativa ou desativa um ponto.
     */
    public function setPointActive(
        int $pointId,
        bool $active
    ): bool {

        /*
         * Só permite ativar ponto se a
         * empresa responsável estiver ativa.
         */
        if ($active) {

            $companyCheck =
                $this->connection->prepare(
                    '
                        SELECT
                            cp.id

                        FROM collection_points AS cp

                        INNER JOIN companies AS c
                            ON c.id = cp.company_id

                        WHERE
                            cp.id = :id
                            AND c.active = 1

                        LIMIT 1
                    '
                );


            $companyCheck->execute([
                'id' => $pointId
            ]);


            if (!$companyCheck->fetch()) {

                return false;
            }
        }


        $statement =
            $this->connection->prepare(
                '
                    UPDATE collection_points

                    SET active = :active

                    WHERE id = :id
                '
            );


        $statement->execute([
            'active' => $active ? 1 : 0,
            'id' => $pointId
        ]);


        return $statement->rowCount() === 1;
    }
}