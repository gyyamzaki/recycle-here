<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    public static function status(int $statusCode): void
    {
        http_response_code($statusCode);
    }

    public static function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }

    public static function json(
        array $data,
        int $statusCode = 200
    ): never {
        http_response_code($statusCode);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES
        );

        exit;
    }
}