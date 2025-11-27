<?php

namespace Deinte\UmamiSdk\Requests\Reports;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Report;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetReportsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param array<string, mixed> $query
     */
    public function __construct(
        protected array $query,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/reports';
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Report::fromResponse($item),
        );
    }
}
