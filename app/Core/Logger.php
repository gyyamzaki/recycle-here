<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

final class Logger
{
    private const LOG_FILE =
        'storage/logs/app.log';


    public static function info(
        string $event,
        array $context = []
    ): void {

        self::write(
            'INFO',
            $event,
            $context
        );
    }


    public static function warning(
        string $event,
        array $context = []
    ): void {

        self::write(
            'WARNING',
            $event,
            $context
        );
    }


    public static function error(
        string $event,
        array $context = []
    ): void {

        self::write(
            'ERROR',
            $event,
            $context
        );
    }


    /**
     * Registra uma exceção sem expor
     * detalhes técnicos ao usuário.
     */
    public static function exception(
        Throwable $exception,
        array $context = []
    ): void {

        $exceptionContext = [
            'exception' =>
                $exception::class,

            'message' =>
                $exception->getMessage(),

            'file' =>
                $exception->getFile(),

            'line' =>
                $exception->getLine()
        ];


        self::error(
            'internal_error',
            array_merge(
                $context,
                $exceptionContext
            )
        );
    }


    private static function write(
        string $level,
        string $event,
        array $context
    ): void {

        try {

            $root =
                dirname(__DIR__, 2);


            $directory =
                $root
                . '/storage/logs';


            if (!is_dir($directory)) {

                mkdir(
                    $directory,
                    0775,
                    true
                );
            }


            $file =
                $root
                . '/'
                . self::LOG_FILE;


            /*
             * Remove qualquer dado que nunca
             * deve aparecer nos logs.
             */
            $context =
                self::sanitizeContext(
                    $context
                );


            $contextJson =
                $context === []
                    ? ''
                    : ' '
                        . json_encode(
                            $context,
                            JSON_UNESCAPED_UNICODE
                            |
                            JSON_UNESCAPED_SLASHES
                        );


            $line =
                sprintf(
                    "[%s] %s %s%s%s",
                    date('Y-m-d H:i:s'),
                    $level,
                    $event,
                    $contextJson,
                    PHP_EOL
                );


            file_put_contents(
                $file,
                $line,
                FILE_APPEND
                |
                LOCK_EX
            );


        } catch (Throwable) {

            /*
             * Um problema no logger não pode
             * derrubar a aplicação.
             */
        }
    }


    private static function sanitizeContext(
        array $context
    ): array {

        $sensitiveKeys = [
            'password',
            'password_hash',
            '_csrf',
            'csrf',
            'token'
        ];


        foreach (
            $sensitiveKeys
            as $key
        ) {

            if (
                array_key_exists(
                    $key,
                    $context
                )
            ) {

                $context[$key] =
                    '[REDACTED]';
            }
        }


        return $context;
    }
}