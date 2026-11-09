<?php

declare(strict_types=1);

namespace App\Core;

final class Request
{
    private ?array $parsedBody = null;
    private bool $invalidJson = false;

    public function method(): string
    {
        return strtoupper(
            $_SERVER['REQUEST_METHOD'] ?? 'GET'
        );
    }

    public function path(): string
    {
        $uri =
            $_SERVER['REQUEST_URI'] ?? '/';

        $path =
            parse_url(
                $uri,
                PHP_URL_PATH
            ) ?: '/';

        if ($path === '/') {
            return '/';
        }

        return '/' . trim($path, '/');
    }

    public function query(
        ?string $key = null,
        mixed $default = null
    ): mixed {

        if ($key === null) {
            return $_GET;
        }

        return $_GET[$key] ?? $default;
    }

    public function input(
        ?string $key = null,
        mixed $default = null
    ): mixed {

        $body = $this->body();

        if ($key === null) {
            return $body;
        }

        return $body[$key] ?? $default;
    }

    public function header(
        string $name,
        mixed $default = null
    ): mixed {

        $normalized = strtoupper(
            str_replace('-', '_', $name)
        );

        if (
            $normalized === 'CONTENT_TYPE'
            ||
            $normalized === 'CONTENT_LENGTH'
        ) {
            return $_SERVER[$normalized] ?? $default;
        }

        return $_SERVER[
            'HTTP_' . $normalized
        ] ?? $default;
    }

    public function hasInvalidJson(): bool
    {
        $this->body();

        return $this->invalidJson;
    }

    private function body(): array
    {
        if ($this->parsedBody !== null) {
            return $this->parsedBody;
        }

        $contentType = strtolower(
            (string) $this->header(
                'Content-Type',
                ''
            )
        );

        if (
            str_contains(
                $contentType,
                'application/json'
            )
        ) {
            $raw =
                file_get_contents(
                    'php://input'
                );

            if (
                $raw === false
                ||
                trim($raw) === ''
            ) {
                $this->parsedBody = [];

                return $this->parsedBody;
            }

            $decoded =
                json_decode(
                    $raw,
                    true
                );

            if (
                json_last_error()
                !==
                JSON_ERROR_NONE
                ||
                !is_array($decoded)
            ) {
                $this->invalidJson = true;
                $this->parsedBody = [];

                return $this->parsedBody;
            }

            $this->parsedBody = $decoded;

            return $this->parsedBody;
        }

        if ($this->method() === 'POST') {
            $this->parsedBody = $_POST;

            return $this->parsedBody;
        }

        if (
            in_array(
                $this->method(),
                ['PUT', 'PATCH', 'DELETE'],
                true
            )
        ) {
            $raw =
                file_get_contents(
                    'php://input'
                );

            $data = [];

            if (
                is_string($raw)
                &&
                $raw !== ''
            ) {
                parse_str(
                    $raw,
                    $data
                );
            }

            $this->parsedBody =
                is_array($data)
                    ? $data
                    : [];

            return $this->parsedBody;
        }

        $this->parsedBody = $_POST;

        return $this->parsedBody;
    }
}
