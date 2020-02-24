<?php

namespace Anso\Framework\Http\Contract\Exception;

use Anso\Framework\Contract\ApplicationException;

interface HttpException extends ApplicationException
{
    public function getMessage();
    public function getCode();
}