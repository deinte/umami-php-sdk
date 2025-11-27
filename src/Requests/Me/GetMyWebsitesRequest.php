<?php

namespace Deinte\UmamiSdk\Requests\Me;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Website;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMyWebsitesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected bool $includeTeams = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/me/websites';
    }

    protected function defaultQuery(): array
    {
        return [
            'includeTeams' => $this->includeTeams,
        ];
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Website::fromResponse($item),
        );
    }
}
