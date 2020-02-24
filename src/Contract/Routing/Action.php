<?php

namespace Anso\Framework\Http\Contract\Routing;

use Anso\Framework\Http\Request;
use Anso\Framework\Http\Response;

interface Action
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Throwable
     */
    public function execute(Request $request): Response;
}