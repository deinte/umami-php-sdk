<?php

namespace Deinte\UmamiSdk\Requests\WebsiteStats;

use Deinte\UmamiSdk\Dto\ExpandedMetric;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetExpandedMetricsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $query
     */
    public function __construct(
        protected string $websiteId,
        protected array $query,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/metrics/expanded";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array<int, ExpandedMetric>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => ExpandedMetric::fromResponse($item),
            $response->json(),
        );
    }
}
