<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\AggregatedValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEventDataValuesRequest extends Request
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
        return "/websites/{$this->websiteId}/event-data/values";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array<int, AggregatedValue>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => new AggregatedValue(name: $item['value'], total: (int) $item['total']),
            $response->json(),
        );
    }
}
