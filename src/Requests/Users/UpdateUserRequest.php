<?php

namespace Deinte\UmamiSdk\Requests\Users;

use Deinte\UmamiSdk\Dto\User;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class UpdateUserRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected string $userId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/{$this->userId}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromResponse($response->json());
    }
}
