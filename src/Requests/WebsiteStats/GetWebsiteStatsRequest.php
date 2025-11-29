<?php

namespace Deinte\UmamiSdk\Requests\WebsiteStats;

use Deinte\UmamiSdk\Dto\WebsiteStatsSummary;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWebsiteStatsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $query
     */
    public function __construct(
        protected string $websiteId,
        protected array $queryParams,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/stats";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    public function createDtoFromResponse(Response $response): WebsiteStatsSummary
    {
        return WebsiteStatsSummary::fromResponse($response->json());
    }
}
