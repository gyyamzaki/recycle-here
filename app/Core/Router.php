<?php

declare(strict_types=1);

namespace App\Core;

use Closure;
use RuntimeException;

final class Router
{
    private array $routes = [];


    public function get(
        string $path,
        array|Closure $handler
    ): void {
        $this->add('GET', $path, $handler);
    }


    public function post(
        string $path,
        array|Closure $handler
    ): void {
        $this->add('POST', $path, $handler);
    }


    public function put(
        string $path,
        array|Closure $handler
    ): void {
        $this->add('PUT', $path, $handler);
    }


    public function delete(
        string $path,
        array|Closure $handler
    ): void {
        $this->add('DELETE', $path, $handler);
    }


    private function add(
        string $method,
        string $path,
        array|Closure $handler
    ): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }


    public function dispatch(Request $request): void
    {
        foreach ($this->routes as $route) {

            if ($route['method'] !== $request->method()) {
                continue;
            }

            $pattern = $this->createPattern(
                $route['path']
            );

            if (
                !preg_match(
                    $pattern,
                    $request->path(),
                    $matches
                )
            ) {
                continue;
            }

            $parameters = [];

            foreach ($matches as $key => $value) {

                if (is_string($key)) {
                    $parameters[] = $value;
                }
            }

            $this->execute(
                $route['handler'],
                $request,
                $parameters
            );

            return;
        }

        http_response_code(404);

        echo '<h1>404</h1>';
        Response::status(404);

        require dirname(__DIR__)
            . '/Views/errors/404.php';
    }


    private function createPattern(string $path): string
    {
        $pattern = preg_replace(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            '(?P<$1>[^/]+)',
            $path
        );

        return '#^' . $pattern . '$#';
    }


    private function execute(
        array|Closure $handler,
        Request $request,
        array $parameters
    ): void {
        if ($handler instanceof Closure) {

            $handler(
                $request,
                ...$parameters
            );

            return;
        }


        [$controllerClass, $method] = $handler;


        if (!class_exists($controllerClass)) {
            throw new RuntimeException(
                "Controller {$controllerClass} não encontrado."
            );
        }


        $controller = new $controllerClass();


        if (!method_exists($controller, $method)) {
            throw new RuntimeException(
                "Método {$method} não encontrado."
            );
        }


        $controller->{$method}(
            $request,
            ...$parameters
        );
    }
}