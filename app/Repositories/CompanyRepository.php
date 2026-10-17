<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

use App\Models\Company;

final class CompanyRepository
{
    private PDO $connection;


    public function __construct(
        ?PDO $connection = null
    ) {
        $this->connection =
            $connection ??
            Database::connection();
    }


    public function cnpjExists(
        string $cnpj
    ): bool {

        $sql = '
            SELECT COUNT(*)

            FROM companies

            WHERE cnpj = :cnpj
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'cnpj' => $cnpj
        ]);


        return (int)
            $statement->fetchColumn() > 0;
    }


    public function create(
        int $userId,
        string $name,
        string $cnpj,
        string $phone
    ): int {

        $sql = '
            INSERT INTO companies (
                user_id,
                name,
                cnpj,
                phone
            )
            VALUES (
                :user_id,
                :name,
                :cnpj,
                :phone
            )
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'user_id' => $userId,
            'name' => $name,
            'cnpj' => $cnpj,
            'phone' => $phone
        ]);


        return (int)
            $this->connection
                ->lastInsertId();
    }

    public function findByUserId(
        int $userId
    ): ?Company {

        $sql = '
            SELECT
                id,
                user_id,
                name,
                cnpj,
                phone,
                active

            FROM companies

            WHERE user_id = :user_id

            LIMIT 1
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'user_id' => $userId
        ]);


        $row =
            $statement->fetch();


        if (!$row) {
            return null;
        }


        return new Company(
            id:
                (int) $row['id'],

            userId:
                (int) $row['user_id'],

            name:
                $row['name'],

            cnpj:
                $row['cnpj'],

            phone:
                $row['phone'],

            active:
                (bool) $row['active']
        );
    }
}