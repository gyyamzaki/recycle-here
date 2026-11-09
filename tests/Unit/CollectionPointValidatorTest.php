<?php

declare(strict_types=1);

use App\Validators\CollectionPointValidator;
use Tests\Support\TestRunner;

return static function (TestRunner $runner): void {
    $validMaterialIds = [1, 2, 3, 4, 5, 6, 7];

    $runner->test('Ponto válido é aceito e normalizado', static function () use ($runner, $validMaterialIds): void {
        $result = CollectionPointValidator::validate([
            'name' => '  Ecoponto Teste  ',
            'street' => '  Rua das Flores  ',
            'number' => '100',
            'complement' => '',
            'neighborhood' => 'Centro',
            'city' => 'Sorocaba',
            'state' => 'sp',
            'zip_code' => '18000-000',
            'phone' => '(15) 99999-9999',
            'opening_hours' => 'Segunda a sexta, 08h às 17h',
            'materials' => [1, '2', 2],
        ], $validMaterialIds);

        $runner->assertSame([], $result['errors']);
        $runner->assertSame('Ecoponto Teste', $result['data']['name']);
        $runner->assertSame('SP', $result['data']['state']);
        $runner->assertSame('18000000', $result['data']['zip_code']);
        $runner->assertSame('15999999999', $result['data']['phone']);
        $runner->assertSame(null, $result['data']['complement']);
        $runner->assertSame([1, 2], $result['data']['materials']);
    });

    $runner->test('Ponto inválido rejeita campos obrigatórios ausentes', static function () use ($runner, $validMaterialIds): void {
        $result = CollectionPointValidator::validate([
            'name' => '',
            'street' => '',
            'number' => '',
            'neighborhood' => '',
            'city' => '',
            'state' => '',
            'opening_hours' => '',
            'materials' => [],
        ], $validMaterialIds);

        $runner->assertContains('Informe o nome do ponto de coleta.', $result['errors']);
        $runner->assertContains('Informe a rua do ponto de coleta.', $result['errors']);
        $runner->assertContains('Informe o número do endereço.', $result['errors']);
        $runner->assertContains('Selecione pelo menos um material aceito.', $result['errors']);
    });

    $runner->test('Ponto rejeita material inexistente ou inativo', static function () use ($runner, $validMaterialIds): void {
        $result = CollectionPointValidator::validate([
            'name' => 'Ecoponto Teste',
            'street' => 'Rua Teste',
            'number' => '10',
            'neighborhood' => 'Centro',
            'city' => 'Sorocaba',
            'state' => 'SP',
            'opening_hours' => '08h às 17h',
            'materials' => [999],
        ], $validMaterialIds);

        $runner->assertContains(
            'Foi selecionado um material inexistente ou inativo.',
            $result['errors']
        );
    });

    $runner->test('Ponto rejeita CEP, telefone e UF inválidos', static function () use ($runner, $validMaterialIds): void {
        $result = CollectionPointValidator::validate([
            'name' => 'Ecoponto Teste',
            'street' => 'Rua Teste',
            'number' => '10',
            'neighborhood' => 'Centro',
            'city' => 'Sorocaba',
            'state' => 'SPO',
            'zip_code' => '123',
            'phone' => '1234',
            'opening_hours' => '08h às 17h',
            'materials' => [1],
        ], $validMaterialIds);

        $runner->assertContains('Informe uma UF válida com duas letras.', $result['errors']);
        $runner->assertContains('O CEP deve possuir 8 números.', $result['errors']);
        $runner->assertContains('O telefone deve possuir 10 ou 11 números.', $result['errors']);
    });
};
