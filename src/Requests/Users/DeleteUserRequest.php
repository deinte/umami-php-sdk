<?php

namespace Deinte\UmamiSdk\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeleteUserRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/{$this->userId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
