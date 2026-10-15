<?php

declare(strict_types=1);

return [

    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'Recycle Here',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => filter_var(
            $_ENV['APP_DEBUG'] ?? false,
            FILTER_VALIDATE_BOOL
        ),
        'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    ],

    'database' => [
        'driver' => 'mysql',

        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',

        'port' => $_ENV['DB_PORT'] ?? '3306',

        'database' => $_ENV['DB_DATABASE'] ?? 'recycle_here',

        'username' => $_ENV['DB_USERNAME'] ?? 'root',

        'password' => $_ENV['DB_PASSWORD'] ?? '',

        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',

        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],

];