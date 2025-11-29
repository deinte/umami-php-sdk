<?php

namespace Deinte\UmamiSdk\Requests\Sessions;

use Deinte\UmamiSdk\Dto\SessionActivityItem;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSessionActivityRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $query
     */
    public function __construct(
        protected string $websiteId,
        protected string $sessionId,
        protected array $queryParams,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/sessions/{$this->sessionId}/activity";
    }

    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array<int, SessionActivityItem>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => SessionActivityItem::fromResponse($item),
            $response->json(),
        );
    }
}
