<?php

namespace Deinte\UmamiSdk\Requests\Websites;

use Deinte\UmamiSdk\Dto\Website;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class UpdateWebsiteRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected string $websiteId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Website
    {
        return Website::fromResponse($response->json());
    }
}
