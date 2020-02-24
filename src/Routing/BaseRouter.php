<?php

namespace Anso\Framework\Http\Routing;

use Anso\Framework\Http\Contract\Routing\Router;

abstract class BaseRouter implements Router
{
    protected static function get(string $uri, $class)
    {
        return [
            'method'  => 'GET',
            'uri'     => $uri,
            'action'  => $class
        ];
    }

    protected static function post(string $uri, $class)
    {
        return [
            'method'  => 'POST',
            'uri'     => $uri,
            'action'  => $class
        ];
    }

    protected static function put(string $uri, $class)
    {
        return [
            'method'  => 'PUT',
            'uri'     => $uri,
            'action'  => $class
        ];
    }

    protected static function delete(string $uri, $class)
    {
        return [
            'method'  => 'DELETE',
            'uri'     => $uri,
            'action'  => $class
        ];
    }
}