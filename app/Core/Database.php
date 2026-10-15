<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;


    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }


        $config = require dirname(__DIR__, 2) . '/config/app.php';

        $database = $config['database'];


        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $database['driver'],
            $database['host'],
            $database['port'],
            $database['database'],
            $database['charset']
        );


        try {

            self::$connection = new PDO(
                $dsn,
                $database['username'],
                $database['password'],
                $database['options']
            );

        } catch (PDOException $exception) {

            throw new RuntimeException(
                'Não foi possível conectar ao banco de dados.',
                0,
                $exception
            );
        }


        return self::$connection;
    }
}