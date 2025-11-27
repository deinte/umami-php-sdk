<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\AggregatedValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEventDataFieldsRequest extends Request
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
        return "/websites/{$this->websiteId}/event-data/fields";
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
            fn (array $item) => AggregatedValue::fromResponse([
                'propertyName' => $item['propertyName'],
                'total' => $item['total'],
            ]),
            $response->json(),
        );
    }
}
