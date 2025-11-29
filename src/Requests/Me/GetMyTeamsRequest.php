<?php

namespace Deinte\UmamiSdk\Requests\Me;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMyTeamsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $queryParams
     */
    public function __construct(
        protected array $queryParams = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/me/teams';
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Team::fromResponse($item),
        );
    }
}
