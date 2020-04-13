<?php

namespace Anso\Framework\Http\Contract\Exception;

use Anso\Framework\Base\Contract\ApplicationException;

interface HttpException extends ApplicationException
{
    public function getMessage();
    public function getCode();
}