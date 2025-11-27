<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Deinte\UmamiSdk\Dto\SessionPropertyRecord;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionPropertiesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
        protected string $sessionId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/sessions/{$this->sessionId}/properties";
    }

    /**
     * @return array<int, SessionPropertyRecord>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => SessionPropertyRecord::fromResponse($item),
            $response->json(),
        );
    }
}
