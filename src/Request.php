<?php

namespace Anso\Framework\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{

    public static function createInstance(): self
    {
        $request = self::createFromGlobals();

        if (
            0 === strpos($request->headers->get('CONTENT-TYPE'), 'application/json')
            && $content = json_decode(file_get_contents('php://input'), true)
        ) {
            $request->request->add($content);
        }

        return $request;
    }

    public function getMethod(): string
    {
        return parent::getMethod();
    }

    public function getUri(): string
    {
        return parent::getRequestUri();
    }

    public function getUriWithoutParameters(): string
    {
        return explode('?', $this->getUri())[0];
    }

    public function getParameters(): array
    {
        $parameters = [];
        $uri = explode('?', $this->getUri());

        if (!isset($uri[1])) {
            return $parameters;
        }

        $parametersAsStrings = explode('&', $uri[1]);

        foreach ($parametersAsStrings as $parameter) {
            $keyValue = explode('=', $parameter);

            if ($keyValue[0]) {
                $parameters[$keyValue[0]] = $keyValue[1] ?? null;
            }
        }

        return $parameters;
    }

    public function get(string $key, $default = null)
    {
        return parent::get($key, $default);
    }

    public function post(string $key, $default = null)
    {
        if (!$result = $this->request->get($key)) {
            $tempResult = json_decode(file_get_contents('php://input'), true);
            $result = $tempResult[$key] ?? null;
        }

        return $result ?? $default;
    }
}