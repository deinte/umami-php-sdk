<?php

namespace Deinte\UmamiSdk\Requests\Websites;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ResetWebsiteRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected string $websiteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/reset";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
