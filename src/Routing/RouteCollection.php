<?php

namespace Anso\Framework\Http\Routing;

class RouteCollection
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function findRoute(string $method, string $uri): string
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                return $route['action'];
            }
        }

        return '';
    }
}
