<?php

declare(strict_types=1);

namespace Tests\Support;

use RuntimeException;
use Throwable;

final class TestRunner
{
    private int $passed = 0;
    private int $failed = 0;

    /** @var array<int, array{name:string, message:string}> */
    private array $failures = [];

    public function test(string $name, callable $test): void
    {
        try {
            $test();
            $this->passed++;
            echo "[PASS] {$name}" . PHP_EOL;
        } catch (Throwable $exception) {
            $this->failed++;
            $this->failures[] = [
                'name' => $name,
                'message' => $exception->getMessage(),
            ];

            echo "[FAIL] {$name}" . PHP_EOL;
            echo "       {$exception->getMessage()}" . PHP_EOL;
        }
    }

    public function assertTrue(bool $condition, string $message = 'Esperado true, recebido false.'): void
    {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }

    public function assertFalse(bool $condition, string $message = 'Esperado false, recebido true.'): void
    {
        if ($condition) {
            throw new RuntimeException($message);
        }
    }

    public function assertSame(mixed $expected, mixed $actual, string $message = ''): void
    {
        if ($expected !== $actual) {
            $detail = sprintf(
                'Esperado %s, recebido %s.',
                var_export($expected, true),
                var_export($actual, true)
            );

            throw new RuntimeException(
                $message !== '' ? $message . ' ' . $detail : $detail
            );
        }
    }

    public function assertArrayHasKey(string|int $key, array $array, string $message = ''): void
    {
        if (!array_key_exists($key, $array)) {
            $detail = sprintf(
                'A chave %s não foi encontrada no array.',
                var_export($key, true)
            );

            throw new RuntimeException(
                $message !== '' ? $message . ' ' . $detail : $detail
            );
        }
    }

    public function assertContains(mixed $needle, array $haystack, string $message = ''): void
    {
        if (!in_array($needle, $haystack, true)) {
            $detail = sprintf(
                'O valor %s não foi encontrado no array.',
                var_export($needle, true)
            );

            throw new RuntimeException(
                $message !== '' ? $message . ' ' . $detail : $detail
            );
        }
    }

    public function finish(): int
    {
        $total = $this->passed + $this->failed;

        echo PHP_EOL;
        echo '----------------------------------------' . PHP_EOL;
        echo "Tests:  {$total}" . PHP_EOL;
        echo "Passed: {$this->passed}" . PHP_EOL;
        echo "Failed: {$this->failed}" . PHP_EOL;
        echo '----------------------------------------' . PHP_EOL;

        if ($this->failed === 0) {
            echo 'OK - todos os testes passaram.' . PHP_EOL;
            return 0;
        }

        echo 'Falhas:' . PHP_EOL;

        foreach ($this->failures as $failure) {
            echo '- ' . $failure['name'] . ': ' . $failure['message'] . PHP_EOL;
        }

        return 1;
    }
}
