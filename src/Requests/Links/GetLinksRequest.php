<?php

namespace Deinte\UmamiSdk\Requests\Links;

use Deinte\UmamiSdk\Dto\Link;
use Deinte\UmamiSdk\Dto\PaginatedResult;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLinksRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param array<string, mixed> $query
     */
    public function __construct(
        protected array $query = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/links';
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Link::fromResponse($item),
        );
    }
}
