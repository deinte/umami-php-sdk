<?php

namespace Deinte\UmamiSdk\Requests\Pixels;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Pixel;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPixelsRequest extends Request
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
        return '/pixels';
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    public function createDtoFromResponse(Response $response): PaginatedResult
    {
        return PaginatedResult::fromResponse(
            $response->json(),
            fn (array $item) => Pixel::fromResponse($item),
        );
    }
}
