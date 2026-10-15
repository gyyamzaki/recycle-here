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


    public function allActive(): array
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
                cp.active = 1
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

            ORDER BY cp.name
        ';


        $statement =
            $this->connection->prepare($sql);

        $statement->execute();


        $points = [];


        foreach ($statement->fetchAll() as $row) {
            $points[] = $this->map($row);
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
}
