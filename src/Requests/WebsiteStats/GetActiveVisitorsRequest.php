<?php

namespace Deinte\UmamiSdk\Requests\WebsiteStats;

use Deinte\UmamiSdk\Dto\ActiveVisitors;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetActiveVisitorsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/active";
    }

    public function createDtoFromResponse(Response $response): ActiveVisitors
    {
        return ActiveVisitors::fromResponse($response->json());
    }
}
