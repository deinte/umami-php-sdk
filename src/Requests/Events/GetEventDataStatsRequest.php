<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\EventDataStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEventDataStatsRequest extends Request
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
        return "/websites/{$this->websiteId}/event-data/stats";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    public function createDtoFromResponse(Response $response): EventDataStats
    {
        return EventDataStats::fromResponse($response->json());
    }
}
