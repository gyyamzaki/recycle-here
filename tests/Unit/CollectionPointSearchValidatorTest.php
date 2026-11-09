<?php

declare(strict_types=1);

use App\Validators\CollectionPointSearchValidator;
use Tests\Support\TestRunner;

return static function (TestRunner $runner): void {
    $validator = new CollectionPointSearchValidator();

    $runner->test('Busca válida normaliza bairro e material', static function () use ($runner, $validator): void {
        $result = $validator->validate([
            'bairro' => '  Centro  ',
            'material' => 'pilhas-baterias',
        ]);

        $runner->assertTrue($result['valid']);
        $runner->assertSame('Centro', $result['data']['bairro']);
        $runner->assertSame('pilhas-baterias', $result['data']['material']);
        $runner->assertSame([], $result['errors']);
    });

    $runner->test('Busca rejeita material com conteúdo inválido', static function () use ($runner, $validator): void {
        $result = $validator->validate([
            'bairro' => 'Centro',
            'material' => '<script>alert(1)</script>',
        ]);

        $runner->assertFalse($result['valid']);
        $runner->assertArrayHasKey('material', $result['errors']);
    });
};
