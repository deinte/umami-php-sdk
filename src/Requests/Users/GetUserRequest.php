<?php

namespace Deinte\UmamiSdk\Requests\Users;

use Deinte\UmamiSdk\Dto\User;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/{$this->userId}";
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromResponse($response->json());
    }
}
