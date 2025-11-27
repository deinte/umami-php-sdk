<?php

namespace Deinte\UmamiSdk\Requests\Auth;

use Deinte\UmamiSdk\Dto\LoginResult;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class LoginRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/auth/login';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): LoginResult
    {
        return LoginResult::fromResponse($response->json());
    }
}
