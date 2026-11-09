<?php

declare(strict_types=1);

use App\Validators\AuthValidator;
use Tests\Support\TestRunner;

return static function (TestRunner $runner): void {
    $validator = new AuthValidator();

    $runner->test('Login válido normaliza o e-mail', static function () use ($runner, $validator): void {
        $result = $validator->validateLogin([
            'email' => '  TESTE@RECYCLEHERE.LOCAL  ',
            'password' => 'Teste123!',
        ]);

        $runner->assertTrue($result['valid']);
        $runner->assertSame('teste@recyclehere.local', $result['data']['email']);
        $runner->assertSame('Teste123!', $result['data']['password']);
        $runner->assertSame([], $result['errors']);
    });

    $runner->test('Login inválido rejeita e-mail e senha vazia', static function () use ($runner, $validator): void {
        $result = $validator->validateLogin([
            'email' => 'email-invalido',
            'password' => '',
        ]);

        $runner->assertFalse($result['valid']);
        $runner->assertArrayHasKey('email', $result['errors']);
        $runner->assertArrayHasKey('password', $result['errors']);
    });

    $runner->test('Cadastro válido normaliza CNPJ, telefone e e-mail', static function () use ($runner, $validator): void {
        $result = $validator->validateRegister([
            'company_name' => '  Cooperativa Teste  ',
            'cnpj' => '12.345.678/0001-90',
            'email' => '  EMPRESA@EXEMPLO.COM  ',
            'phone' => '(15) 99999-9999',
            'password' => 'Senha123!',
            'password_confirmation' => 'Senha123!',
        ]);

        $runner->assertTrue($result['valid']);
        $runner->assertSame('Cooperativa Teste', $result['data']['company_name']);
        $runner->assertSame('12345678000190', $result['data']['cnpj']);
        $runner->assertSame('empresa@exemplo.com', $result['data']['email']);
        $runner->assertSame('15999999999', $result['data']['phone']);
    });

    $runner->test('Cadastro inválido rejeita dados inconsistentes', static function () use ($runner, $validator): void {
        $result = $validator->validateRegister([
            'company_name' => '',
            'cnpj' => '123',
            'email' => 'invalido',
            'phone' => '1234',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        $runner->assertFalse($result['valid']);
        $runner->assertArrayHasKey('company_name', $result['errors']);
        $runner->assertArrayHasKey('cnpj', $result['errors']);
        $runner->assertArrayHasKey('email', $result['errors']);
        $runner->assertArrayHasKey('phone', $result['errors']);
        $runner->assertArrayHasKey('password', $result['errors']);
        $runner->assertArrayHasKey('password_confirmation', $result['errors']);
    });
};
