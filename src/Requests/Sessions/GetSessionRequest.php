<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Deinte\UmamiSdk\Dto\Session;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
        protected string $sessionId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/sessions/{$this->sessionId}";
    }

    public function createDtoFromResponse(Response $response): Session
    {
        return Session::fromResponse($response->json());
    }
}
