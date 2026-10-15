<?php

declare(strict_types=1);

namespace App\Validators;

final class CollectionPointSearchValidator
{
    public function validate(array $input): array
    {
        $errors = [];

        $neighborhood = trim(
            (string) ($input['bairro'] ?? '')
        );

        $material = trim(
            (string) ($input['material'] ?? '')
        );


        if (mb_strlen($neighborhood) > 100) {
            $errors['bairro'] =
                'O bairro ou região deve possuir no máximo 100 caracteres.';
        }


        if (
            $material !== '' &&
            (
                mb_strlen($material) > 80 ||
                !preg_match(
                    '/^[a-z0-9-]+$/',
                    $material
                )
            )
        ) {
            $errors['material'] =
                'O material informado é inválido.';
        }


        return [
            'valid' => empty($errors),

            'data' => [
                'bairro' => $neighborhood,
                'material' => $material,
            ],

            'errors' => $errors,
        ];
    }
}
