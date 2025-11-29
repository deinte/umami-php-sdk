<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Deinte\UmamiSdk\Dto\AggregatedValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionDataPropertiesRequest extends Request
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
        return "/websites/{$this->websiteId}/session-data/properties";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array<int, AggregatedValue>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => AggregatedValue::fromResponse($item),
            $response->json(),
        );
    }
}
