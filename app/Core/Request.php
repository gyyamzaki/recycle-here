<?php

declare(strict_types=1);

namespace App\Core;

final class Request
{
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

        if ($key === null) {
            return $_POST;
        }


        return $_POST[$key] ?? $default;
    }
}