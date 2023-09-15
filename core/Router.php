<?php

namespace Core;

use Exception;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public static function load(string $file): Router
    {
        $router = new static();
        include $file;

        return $router;
    }

    public function get($uri, $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct(string $uri, string $method)
    {
        if (array_key_exists($uri, $this->routes[$method])) {
            return $this->callAction(...explode('@', $this->routes[$method][$uri]));
        }

        return 'app/Views/404.php';
    }

    /**
     * @throws \Exception
     */
    protected function callAction($controller, $action)
    {
        $controller =  "App\\Controllers\\{$controller}";
        $controller = new $controller();

        if (! method_exists($controller, $action)) {
            throw new Exception("{$controller} does not have {$action}");
        }

        return $controller->$action();
    }
}
