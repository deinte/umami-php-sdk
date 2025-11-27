<?php

namespace Deinte\UmamiSdk\Exceptions;

use Saloon\Http\Response;

class ValidationException extends UmamiException
{
    /** @var array<string, array<int, string>> */
    protected array $errors = [];

    public function __construct(Response $response)
    {
        parent::__construct($response, 'The request body was not valid.');

        $this->errors = $response->json('errors', []);
    }

    /** @return array<int, string> */
    public function errors(): array
    {
        return array_merge(...array_values($this->errors) ?: [[]]);
    }

    /** @return array<int, string> */
    public function getErrorsForField(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
