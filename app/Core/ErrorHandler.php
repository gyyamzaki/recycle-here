<?php

declare(strict_types=1);

namespace App\Core;

use ErrorException;
use Throwable;

final class ErrorHandler
{
    private static bool $handling =
        false;


    public static function register(): void
    {
        /*
         * Exceções não tratadas.
         */
        set_exception_handler(
            [
                self::class,
                'handleException'
            ]
        );


        /*
         * Fatal errors que acontecem
         * no encerramento do PHP.
         */
        register_shutdown_function(
            [
                self::class,
                'handleShutdown'
            ]
        );
    }


    public static function handleException(
        Throwable $exception
    ): void {

        /*
         * Evita loop caso ocorra erro
         * enquanto o próprio handler
         * estiver trabalhando.
         */
        if (self::$handling) {

            http_response_code(500);

            echo 'Erro interno do servidor.';

            return;
        }


        self::$handling = true;


        Logger::exception(
            $exception,
            [
                'method' =>
                    $_SERVER[
                        'REQUEST_METHOD'
                    ]
                    ??
                    null,

                'uri' =>
                    $_SERVER[
                        'REQUEST_URI'
                    ]
                    ??
                    null
            ]
        );


        /*
         * Remove qualquer conteúdo parcial
         * produzido antes da exceção.
         */
        while (
            ob_get_level() > 0
        ) {

            ob_end_clean();
        }


        http_response_code(500);


        $debug =
            filter_var(
                $_ENV['APP_DEBUG']
                ??
                false,
                FILTER_VALIDATE_BOOLEAN
            );


        $debugMessage = null;


        if ($debug) {

            $debugMessage =
                sprintf(
                    '%s: %s',
                    $exception::class,
                    $exception->getMessage()
                );
        }


        /*
         * Se futuramente o erro acontecer
         * em uma rota da API, retorna JSON.
         */
        $path =
            parse_url(
                $_SERVER[
                    'REQUEST_URI'
                ]
                ??
                '/',
                PHP_URL_PATH
            );


        if (
            is_string($path)
            &&
            str_starts_with(
                $path,
                '/api'
            )
        ) {

            header(
                'Content-Type: application/json; charset=utf-8'
            );


            $response = [
                'error' => [
                    'status' => 500,
                    'message' =>
                        'Erro interno do servidor.'
                ]
            ];


            if (
                $debug
                &&
                $debugMessage !== null
            ) {

                $response['error']['debug'] =
                    $debugMessage;
            }


            echo json_encode(
                $response,
                JSON_UNESCAPED_UNICODE
                |
                JSON_UNESCAPED_SLASHES
            );


            self::$handling = false;

            return;
        }


        $view =
            dirname(__DIR__)
            . '/Views/errors/500.php';


        if (is_file($view)) {

            require $view;

        } else {

            echo 'Erro interno do servidor.';
        }


        self::$handling = false;
    }


    public static function handleShutdown(): void
    {
        $error =
            error_get_last();


        if ($error === null) {

            return;
        }


        $fatalTypes = [
            E_ERROR,
            E_PARSE,
            E_CORE_ERROR,
            E_COMPILE_ERROR
        ];


        if (
            !in_array(
                $error['type'],
                $fatalTypes,
                true
            )
        ) {

            return;
        }


        $exception =
            new ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            );


        self::handleException(
            $exception
        );
    }
}