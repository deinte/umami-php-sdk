<?php

namespace Deinte\UmamiSdk\Exceptions;

use Exception;
use Saloon\Http\Response;

class UmamiException extends Exception
{
    public function __construct(
        public readonly Response $response,
        string $message = 'Request failed',
        int $code = 0,
    ) {
        parent::__construct($message, $code);
    }
}
