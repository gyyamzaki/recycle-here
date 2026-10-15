<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Session;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use PDO;
use Throwable;

final class AuthService
{
    private PDO $connection;

    private UserRepository $userRepository;

    private CompanyRepository $companyRepository;


    public function __construct()
    {
        $this->connection =
            Database::connection();


        $this->userRepository =
            new UserRepository(
                $this->connection
            );


        $this->companyRepository =
            new CompanyRepository(
                $this->connection
            );
    }


    public function registerCompany(
        array $data
    ): array {

        if (
            $this->userRepository
                ->emailExists(
                    $data['email']
                )
        ) {

            return [
                'success' => false,

                'errors' => [
                    'email' =>
                        'Este e-mail já está cadastrado.'
                ]
            ];
        }


        if (
            $this->companyRepository
                ->cnpjExists(
                    $data['cnpj']
                )
        ) {

            return [
                'success' => false,

                'errors' => [
                    'cnpj' =>
                        'Este CNPJ já está cadastrado.'
                ]
            ];
        }


        try {

            $this->connection
                ->beginTransaction();


            $passwordHash =
                password_hash(
                    $data['password'],
                    PASSWORD_DEFAULT
                );


            $userId =
                $this->userRepository
                    ->create(
                        $data['company_name'],
                        $data['email'],
                        $passwordHash,
                        'company'
                    );


            $companyId =
                $this->companyRepository
                    ->create(
                        $userId,
                        $data['company_name'],
                        $data['cnpj'],
                        $data['phone']
                    );


            $this->connection
                ->commit();


            return [
                'success' => true,

                'user_id' =>
                    $userId,

                'company_id' =>
                    $companyId
            ];

        } catch (Throwable $exception) {

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


    public function login(
        string $email,
        string $password
    ): bool {

        $user =
            $this->userRepository
                ->findByEmail(
                    $email
                );


        if (
            $user === null ||
            !$user->active
        ) {
            return false;
        }


        if (
            !password_verify(
                $password,
                $user->passwordHash
            )
        ) {
            return false;
        }


        Session::regenerate();


        Session::put(
            'user',
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        );


        return true;
    }


    public function logout(): void
    {
        Session::destroy();
    }
}