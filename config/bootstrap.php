<?php

declare(strict_types=1);

$rootPath = dirname(__DIR__);

require_once $rootPath . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->safeLoad();

App\Core\Session::start();

$debug = filter_var(
    $_ENV['APP_DEBUG'] ?? false,
    FILTER_VALIDATE_BOOL
);

error_reporting(E_ALL);

ini_set(
    'display_errors',
    $debug ? '1' : '0'
);

date_default_timezone_set('America/Sao_Paulo');