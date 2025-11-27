<?php

namespace Deinte\UmamiSdk\Requests\WebsiteStats;

use Deinte\UmamiSdk\Dto\PageviewSeries;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPageviewsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param array<string, mixed> $query
     */
    public function __construct(
        protected string $websiteId,
        protected array $query,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/pageviews";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    public function createDtoFromResponse(Response $response): PageviewSeries
    {
        return PageviewSeries::fromResponse($response->json());
    }
}
