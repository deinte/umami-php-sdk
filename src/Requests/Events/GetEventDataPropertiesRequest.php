<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\EventDataAggregate;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEventDataPropertiesRequest extends Request
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
        return "/websites/{$this->websiteId}/event-data/properties";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array<int, EventDataAggregate>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => EventDataAggregate::fromResponse($item),
            $response->json(),
        );
    }
}
