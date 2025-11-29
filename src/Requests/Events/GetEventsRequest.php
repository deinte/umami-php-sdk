<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\EventRecord;
use Deinte\UmamiSdk\Dto\PaginatedResult;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetEventsRequest extends Request implements Paginatable
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
        return "/websites/{$this->websiteId}/events";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => EventRecord::fromResponse($item),
        );
    }
}
