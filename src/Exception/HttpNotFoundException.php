<?php

namespace Anso\Framework\Http\Exception;

use Anso\Framework\Http\Contract\Exception\HttpException;
use Exception;
use Throwable;

class HttpNotFoundException extends Exception implements HttpException
{
    protected $code = 404;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message . ' page was not found';

        parent::__construct($message, $code, $previous);
    }
}