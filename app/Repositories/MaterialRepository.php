<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Material;
use PDO;

final class MaterialRepository
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
                id,
                name,
                slug

            FROM materials

            WHERE active = 1

            ORDER BY name
        ';


        $statement =
            $this->connection->prepare($sql);


        $statement->execute();


        $materials = [];


        foreach ($statement->fetchAll() as $row) {

            $materials[] =
                new Material(
                    id: (int) $row['id'],
                    name: $row['name'],
                    slug: $row['slug']
                );
        }


        return $materials;
    }
}
