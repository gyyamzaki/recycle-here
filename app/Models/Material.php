<?php

declare(strict_types=1);

namespace App\Models;

final class Material
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug
    ) {
    }
}
