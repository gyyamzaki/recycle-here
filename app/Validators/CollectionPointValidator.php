<?php

declare(strict_types=1);

namespace App\Validators;

final class CollectionPointValidator
{
    public static function validate(
        array $input,
        array $validMaterialIds = []
    ): array {

        $errors = [];


        // -----------------------------------------------------
        // Normalização dos campos
        // -----------------------------------------------------

        $name =
            trim((string) ($input['name'] ?? ''));

        $street =
            trim((string) ($input['street'] ?? ''));

        $number =
            trim((string) ($input['number'] ?? ''));

        $complement =
            trim((string) ($input['complement'] ?? ''));

        $neighborhood =
            trim((string) ($input['neighborhood'] ?? ''));

        $city =
            trim((string) ($input['city'] ?? ''));

        $state =
            strtoupper(
                trim((string) ($input['state'] ?? ''))
            );

        $zipCode =
            preg_replace(
                '/\D/',
                '',
                (string) ($input['zip_code'] ?? '')
            );

        $phone =
            preg_replace(
                '/\D/',
                '',
                (string) ($input['phone'] ?? '')
            );

        $openingHours =
            trim((string) ($input['opening_hours'] ?? ''));


        // -----------------------------------------------------
        // Materiais
        // -----------------------------------------------------

        $materialIds = [];

        $materialsInput =
            $input['materials'] ?? [];


        if (!is_array($materialsInput)) {

            $errors[] =
                'A seleção de materiais é inválida.';

        } else {

            foreach ($materialsInput as $materialId) {

                $materialId =
                    (string) $materialId;


                if (
                    !ctype_digit($materialId)
                    ||
                    (int) $materialId <= 0
                ) {

                    $errors[] =
                        'Foi informado um material inválido.';

                    continue;
                }


                $materialIds[] =
                    (int) $materialId;
            }


            $materialIds =
                array_values(
                    array_unique($materialIds)
                );
        }


        // -----------------------------------------------------
        // Validação do nome
        // -----------------------------------------------------

        if ($name === '') {

            $errors[] =
                'Informe o nome do ponto de coleta.';

        } elseif (mb_strlen($name) > 150) {

            $errors[] =
                'O nome do ponto deve possuir no máximo 150 caracteres.';
        }


        // -----------------------------------------------------
        // Endereço
        // -----------------------------------------------------

        if ($street === '') {

            $errors[] =
                'Informe a rua do ponto de coleta.';

        } elseif (mb_strlen($street) > 180) {

            $errors[] =
                'A rua deve possuir no máximo 180 caracteres.';
        }


        if ($number === '') {

            $errors[] =
                'Informe o número do endereço.';

        } elseif (mb_strlen($number) > 20) {

            $errors[] =
                'O número deve possuir no máximo 20 caracteres.';
        }


        if (mb_strlen($complement) > 100) {

            $errors[] =
                'O complemento deve possuir no máximo 100 caracteres.';
        }


        if ($neighborhood === '') {

            $errors[] =
                'Informe o bairro.';

        } elseif (mb_strlen($neighborhood) > 100) {

            $errors[] =
                'O bairro deve possuir no máximo 100 caracteres.';
        }


        if ($city === '') {

            $errors[] =
                'Informe a cidade.';

        } elseif (mb_strlen($city) > 100) {

            $errors[] =
                'A cidade deve possuir no máximo 100 caracteres.';
        }


        if (
            !preg_match(
                '/^[A-Z]{2}$/',
                $state
            )
        ) {

            $errors[] =
                'Informe uma UF válida com duas letras.';
        }


        // -----------------------------------------------------
        // CEP
        // -----------------------------------------------------

        if (
            $zipCode !== ''
            &&
            strlen($zipCode) !== 8
        ) {

            $errors[] =
                'O CEP deve possuir 8 números.';
        }


        // -----------------------------------------------------
        // Telefone
        // -----------------------------------------------------

        if (
            $phone !== ''
            &&
            (
                strlen($phone) < 10
                ||
                strlen($phone) > 11
            )
        ) {

            $errors[] =
                'O telefone deve possuir 10 ou 11 números.';
        }


        // -----------------------------------------------------
        // Horário
        // -----------------------------------------------------

        if ($openingHours === '') {

            $errors[] =
                'Informe o horário de atendimento.';

        } elseif (mb_strlen($openingHours) > 255) {

            $errors[] =
                'O horário de atendimento deve possuir no máximo 255 caracteres.';
        }


        // -----------------------------------------------------
        // Materiais
        // -----------------------------------------------------

        if (count($materialIds) === 0) {

            $errors[] =
                'Selecione pelo menos um material aceito.';
        }


        foreach ($materialIds as $materialId) {

            if (
                !in_array(
                    $materialId,
                    $validMaterialIds,
                    true
                )
            ) {

                $errors[] =
                    'Foi selecionado um material inexistente ou inativo.';

                break;
            }
        }


        // -----------------------------------------------------
        // Dados já tratados para Service/Repository
        // -----------------------------------------------------

        $data = [

            'name' =>
                $name,

            'street' =>
                $street,

            'number' =>
                $number,

            'complement' =>
                $complement !== ''
                    ? $complement
                    : null,

            'neighborhood' =>
                $neighborhood,

            'city' =>
                $city,

            'state' =>
                $state,

            'zip_code' =>
                $zipCode !== ''
                    ? $zipCode
                    : null,

            'phone' =>
                $phone !== ''
                    ? $phone
                    : null,

            'opening_hours' =>
                $openingHours,

            'materials' =>
                $materialIds
        ];


        return [
            'data' => $data,
            'errors' => $errors
        ];
    }
}