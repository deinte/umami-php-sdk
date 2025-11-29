<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Deinte\UmamiSdk\Dto\SessionStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionStatsRequest extends Request
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
        return "/websites/{$this->websiteId}/sessions/stats";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    public function createDtoFromResponse(Response $response): SessionStats
    {
        return SessionStats::fromResponse($response->json());
    }
}
