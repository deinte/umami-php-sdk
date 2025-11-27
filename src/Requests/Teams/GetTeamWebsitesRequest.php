<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Website;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamWebsitesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $query
     */
    public function __construct(
        protected string $teamId,
        protected array $query = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}/websites";
    }

    protected function defaultQuery(): array
    {
        return $this->query;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Website::fromResponse($item),
        );
    }
}
