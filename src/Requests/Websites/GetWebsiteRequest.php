<?php

namespace Deinte\UmamiSdk\Requests\Websites;

use Deinte\UmamiSdk\Dto\Website;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWebsiteRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}";
    }

    public function createDtoFromResponse(Response $response): Website
    {
        return Website::fromResponse($response->json());
    }
}
