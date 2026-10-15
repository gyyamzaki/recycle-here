<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\User;
use PDO;

final class UserRepository
{
    private PDO $connection;


    public function __construct(
        ?PDO $connection = null
    ) {
        $this->connection =
            $connection ??
            Database::connection();
    }


    public function findByEmail(
        string $email
    ): ?User {

        $sql = '
            SELECT
                id,
                name,
                email,
                password_hash,
                role,
                active

            FROM users

            WHERE email = :email

            LIMIT 1
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'email' => $email
        ]);


        $row =
            $statement->fetch();


        if (!$row) {
            return null;
        }


        return $this->map($row);
    }


    public function emailExists(
        string $email
    ): bool {

        $sql = '
            SELECT COUNT(*)

            FROM users

            WHERE email = :email
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'email' => $email
        ]);


        return (int)
            $statement->fetchColumn() > 0;
    }


    public function create(
        string $name,
        string $email,
        string $passwordHash,
        string $role = 'company'
    ): int {

        $sql = '
            INSERT INTO users (
                name,
                email,
                password_hash,
                role
            )
            VALUES (
                :name,
                :email,
                :password_hash,
                :role
            )
        ';


        $statement =
            $this->connection->prepare(
                $sql
            );


        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => $role
        ]);


        return (int)
            $this->connection
                ->lastInsertId();
    }


    private function map(
        array $row
    ): User {

        return new User(
            id: (int) $row['id'],

            name:
                $row['name'],

            email:
                $row['email'],

            passwordHash:
                $row['password_hash'],

            role:
                $row['role'],

            active:
                (bool) $row['active']
        );
    }
}