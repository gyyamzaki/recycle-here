<?php

declare(strict_types=1);

namespace App\Models;

final class CollectionPoint
{
    public function __construct(
        public readonly int $id,
        public readonly int $companyId,
        public readonly string $name,
        public readonly string $street,
        public readonly string $number,
        public readonly ?string $complement,
        public readonly string $neighborhood,
        public readonly string $city,
        public readonly string $state,
        public readonly ?string $zipCode,
        public readonly ?string $phone,
        public readonly string $openingHours,
        public readonly string $companyName,
        public readonly array $materials,
        public readonly array $materialSlugs
    ) {
    }
}