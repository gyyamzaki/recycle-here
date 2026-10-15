<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

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
}