<?php

namespace Deinte\UmamiSdk\Requests\Realtime;

use Deinte\UmamiSdk\Dto\RealtimeSnapshot;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetRealtimeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/realtime/{$this->websiteId}";
    }

    public function createDtoFromResponse(Response $response): RealtimeSnapshot
    {
        return RealtimeSnapshot::fromResponse($response->json());
    }
}
