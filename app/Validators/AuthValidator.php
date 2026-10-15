<?php

declare(strict_types=1);

namespace App\Validators;

final class AuthValidator
{
    public function validateLogin(
        array $input
    ): array {

        $errors = [];


        $email =
            mb_strtolower(
                trim(
                    (string)
                    ($input['email'] ?? '')
                )
            );


        $password =
            (string)
            ($input['password'] ?? '');


        if (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors['email'] =
                'Informe um e-mail válido.';
        }


        if ($password === '') {

            $errors['password'] =
                'Informe sua senha.';
        }


        return [
            'valid' => empty($errors),

            'data' => [
                'email' => $email,
                'password' => $password
            ],

            'errors' => $errors
        ];
    }


    public function validateRegister(
        array $input
    ): array {

        $errors = [];


        $companyName =
            trim(
                (string)
                ($input['company_name'] ?? '')
            );


        $cnpj =
            preg_replace(
                '/\D/',
                '',
                (string)
                ($input['cnpj'] ?? '')
            );


        $email =
            mb_strtolower(
                trim(
                    (string)
                    ($input['email'] ?? '')
                )
            );


        $phone =
            preg_replace(
                '/\D/',
                '',
                (string)
                ($input['phone'] ?? '')
            );


        $password =
            (string)
            ($input['password'] ?? '');


        $passwordConfirmation =
            (string)
            (
                $input[
                    'password_confirmation'
                ] ?? ''
            );


        if (
            $companyName === '' ||
            mb_strlen($companyName) > 150
        ) {

            $errors['company_name'] =
                'Informe um nome de empresa válido.';
        }


        if (
            strlen($cnpj) !== 14
        ) {

            $errors['cnpj'] =
                'O CNPJ deve possuir 14 dígitos.';
        }


        if (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors['email'] =
                'Informe um e-mail válido.';
        }


        if (
            strlen($phone) < 10 ||
            strlen($phone) > 11
        ) {

            $errors['phone'] =
                'Informe um telefone válido.';
        }


        if (
            strlen($password) < 8
        ) {

            $errors['password'] =
                'A senha deve possuir pelo menos 8 caracteres.';
        }


        if (
            $password !==
            $passwordConfirmation
        ) {

            $errors[
                'password_confirmation'
            ] =
                'As senhas informadas não coincidem.';
        }


        return [
            'valid' => empty($errors),

            'data' => [
                'company_name' =>
                    $companyName,

                'cnpj' =>
                    $cnpj,

                'email' =>
                    $email,

                'phone' =>
                    $phone,

                'password' =>
                    $password
            ],

            'errors' =>
                $errors
        ];
    }
}