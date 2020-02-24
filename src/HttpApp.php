<?php

namespace Anso\Framework\Http;

use Anso\Framework\Base\BaseApp;
use Anso\Framework\Http\Routing\FrontController;
use Throwable;

class HttpApp extends BaseApp
{
    public function start(): void
    {
        $request = Request::createInstance();
        $exceptionHandler = $this->configuration->exceptionHandler();

        try {
            $controller = $this->container->make(FrontController::class);
            $response = $controller->handle($request);
            $response->send();
        } catch (Throwable $e) {
            $exceptionHandler->handle($e);
        }
    }
}