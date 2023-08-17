<?php

namespace app\Core;

use app\Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri and $route['method'] === strtoupper($method)) {

                Middleware::resolve($route['middleware'] ?? '');

                $controllerWithAction = $this->explodeControllerAndAction($route['controller']);

                return loadController($controllerWithAction['controllerPath'], $controllerWithAction['action']);
            }
        }

        abort();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    private function explodeControllerAndAction(string $controller): array {
        $handle = explode('@', $controller);

        return [
            'controllerPath' => $handle[0],
            'action' => $handle[1]
        ];
    }
}
