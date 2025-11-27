<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionWeeklyRequest extends Request
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
        return "/websites/{$this->websiteId}/sessions/weekly";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    /** @return array<int, array<int, int>> */
    public function createDtoFromResponse(Response $response): array
    {
        return $response->json();
    }
}
