<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\CollectionPoint;
use PDO;

final class CollectionPointRepository
{
    private PDO $connection;


    public function __construct(?PDO $connection = null)
    {
        $this->connection =
            $connection ?? Database::connection();
    }


    public function searchActive(
        string $neighborhood = '',
        string $materialSlug = ''
    ): array {

        $conditions = [
            'cp.active = 1',
            'c.active = 1',
        ];


        $parameters = [];


        if ($neighborhood !== '') {

            $conditions[] =
                'cp.neighborhood LIKE :neighborhood';

            $parameters['neighborhood'] =
                '%' . $neighborhood . '%';
        }


        if ($materialSlug !== '') {

            $conditions[] = '
                EXISTS (
                    SELECT 1

                    FROM collection_point_material cpm_filter

                    INNER JOIN materials m_filter
                        ON m_filter.id =
                            cpm_filter.material_id

                    WHERE
                        cpm_filter.collection_point_id = cp.id
                        AND m_filter.slug = :material_slug
                        AND m_filter.active = 1
                )
            ';

            $parameters['material_slug'] =
                $materialSlug;
        }


        $where =
            implode(
                ' AND ',
                $conditions
            );


        $sql = "
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

                c.name AS company_name,

                GROUP_CONCAT(
                    m.name
                    ORDER BY m.name
                    SEPARATOR '||'
                ) AS materials,

                GROUP_CONCAT(
                    m.slug
                    ORDER BY m.name
                    SEPARATOR '||'
                ) AS material_slugs

            FROM collection_points cp

            INNER JOIN companies c
                ON c.id = cp.company_id

            LEFT JOIN collection_point_material cpm
                ON cpm.collection_point_id = cp.id

            LEFT JOIN materials m
                ON m.id = cpm.material_id
                AND m.active = 1

            WHERE {$where}

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
                c.name

            ORDER BY cp.name
        ";


        $statement =
            $this->connection->prepare($sql);


        $statement->execute(
            $parameters
        );


        $points = [];


        foreach ($statement->fetchAll() as $row) {

            $points[] =
                $this->map($row);
        }


        return $points;
    }


    public function findActiveById(int $id): ?CollectionPoint
    {
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
                c.name AS company_name,

                GROUP_CONCAT(
                    m.name
                    ORDER BY m.name
                    SEPARATOR "||"
                ) AS materials,

                GROUP_CONCAT(
                    m.slug
                    ORDER BY m.name
                    SEPARATOR "||"
                ) AS material_slugs

            FROM collection_points cp

            INNER JOIN companies c
                ON c.id = cp.company_id

            LEFT JOIN collection_point_material cpm
                ON cpm.collection_point_id = cp.id

            LEFT JOIN materials m
                ON m.id = cpm.material_id
                AND m.active = 1

            WHERE
                cp.id = :id
                AND cp.active = 1
                AND c.active = 1

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
                c.name

            LIMIT 1
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute([
            'id' => $id
        ]);


        $row = $statement->fetch();


        if (!$row) {
            return null;
        }


        return $this->map($row);
    }


    private function map(array $row): CollectionPoint
    {
        $materials =
            !empty($row['materials'])
                ? explode('||', $row['materials'])
                : [];


        $materialSlugs =
            !empty($row['material_slugs'])
                ? explode('||', $row['material_slugs'])
                : [];


        return new CollectionPoint(
            id: (int) $row['id'],

            companyId:
                (int) $row['company_id'],

            name:
                $row['name'],

            street:
                $row['street'],

            number:
                $row['number'],

            complement:
                $row['complement'],

            neighborhood:
                $row['neighborhood'],

            city:
                $row['city'],

            state:
                $row['state'],

            zipCode:
                $row['zip_code'],

            phone:
                $row['phone'],

            openingHours:
                $row['opening_hours'],

            companyName:
                $row['company_name'],

            materials:
                $materials,

            materialSlugs:
                $materialSlugs
        );
    }

    public function findByCompanyId(
        int $companyId
    ): array {

        $sql = "
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

                c.name AS company_name,

                GROUP_CONCAT(
                    m.name
                    ORDER BY m.name
                    SEPARATOR '||'
                ) AS materials,

                GROUP_CONCAT(
                    m.slug
                    ORDER BY m.name
                    SEPARATOR '||'
                ) AS material_slugs

            FROM collection_points cp

            INNER JOIN companies c
                ON c.id = cp.company_id

            LEFT JOIN collection_point_material cpm
                ON cpm.collection_point_id =
                    cp.id

            LEFT JOIN materials m
                ON m.id =
                    cpm.material_id

            WHERE
                cp.company_id = :company_id
                AND cp.active = 1

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
                c.name

            ORDER BY cp.name
        ";


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'company_id' =>
                $companyId
        ]);


        $points = [];


        foreach (
            $statement->fetchAll()
            as $row
        ) {

            $points[] =
                $this->map($row);
        }


        return $points;
    }

    public function createWithMaterials(
        int $companyId,
        array $data
    ): int {

        try {

            $this->connection
                ->beginTransaction();


            $sql = '
                INSERT INTO collection_points
                (
                    company_id,
                    name,
                    street,
                    number,
                    complement,
                    neighborhood,
                    city,
                    state,
                    zip_code,
                    phone,
                    opening_hours,
                    active
                )
                VALUES
                (
                    :company_id,
                    :name,
                    :street,
                    :number,
                    :complement,
                    :neighborhood,
                    :city,
                    :state,
                    :zip_code,
                    :phone,
                    :opening_hours,
                    1
                )
            ';


            $statement =
                $this->connection
                    ->prepare($sql);


            $statement->execute([

                'company_id' =>
                    $companyId,

                'name' =>
                    $data['name'],

                'street' =>
                    $data['street'],

                'number' =>
                    $data['number'],

                'complement' =>
                    $data['complement'],

                'neighborhood' =>
                    $data['neighborhood'],

                'city' =>
                    $data['city'],

                'state' =>
                    $data['state'],

                'zip_code' =>
                    $data['zip_code'],

                'phone' =>
                    $data['phone'],

                'opening_hours' =>
                    $data['opening_hours']
            ]);


            $pointId =
                (int) $this->connection
                    ->lastInsertId();


            $materialSql = '
                INSERT INTO collection_point_material
                (
                    collection_point_id,
                    material_id
                )
                VALUES
                (
                    :collection_point_id,
                    :material_id
                )
            ';


            $materialStatement =
                $this->connection
                    ->prepare($materialSql);


            foreach (
                $data['materials']
                as $materialId
            ) {

                $materialStatement->execute([

                    'collection_point_id' =>
                        $pointId,

                    'material_id' =>
                        $materialId
                ]);
            }


            $this->connection
                ->commit();


            return $pointId;

        } catch (\Throwable $exception) {

            if (
                $this->connection
                    ->inTransaction()
            ) {

                $this->connection
                    ->rollBack();
            }


            throw $exception;
        }
    }

    public function updateWithMaterials(
        int $pointId,
        int $companyId,
        array $data
    ): void {

        try {

            $this->connection->beginTransaction();


            $sql = '
                UPDATE collection_points
                SET
                    name = :name,
                    street = :street,
                    number = :number,
                    complement = :complement,
                    neighborhood = :neighborhood,
                    city = :city,
                    state = :state,
                    zip_code = :zip_code,
                    phone = :phone,
                    opening_hours = :opening_hours,
                    updated_at = CURRENT_TIMESTAMP
                WHERE
                    id = :id
                    AND company_id = :company_id
            ';


            $statement =
                $this->connection->prepare($sql);


            $statement->execute([
                'name' => $data['name'],
                'street' => $data['street'],
                'number' => $data['number'],
                'complement' => $data['complement'],
                'neighborhood' => $data['neighborhood'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
                'phone' => $data['phone'],
                'opening_hours' => $data['opening_hours'],

                'id' => $pointId,
                'company_id' => $companyId
            ]);


            /*
            * Remove as relações antigas.
            */
            $deleteMaterials =
                $this->connection->prepare(
                    '
                        DELETE FROM collection_point_material
                        WHERE collection_point_id = :point_id
                    '
                );


            $deleteMaterials->execute([
                'point_id' => $pointId
            ]);


            /*
            * Grava novamente os materiais selecionados.
            */
            $insertMaterial =
                $this->connection->prepare(
                    '
                        INSERT INTO collection_point_material
                        (
                            collection_point_id,
                            material_id
                        )
                        VALUES
                        (
                            :point_id,
                            :material_id
                        )
                    '
                );


            foreach ($data['materials'] as $materialId) {

                $insertMaterial->execute([
                    'point_id' => $pointId,
                    'material_id' => $materialId
                ]);
            }


            $this->connection->commit();

        } catch (\Throwable $exception) {

            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }

            throw $exception;
        }
    }
}
