<?php

namespace Deinte\UmamiSdk\Requests\Events;

use Deinte\UmamiSdk\Dto\EventDataRecord;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEventDataRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $websiteId,
        protected string $eventId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}/event-data/{$this->eventId}";
    }

    /**
     * @return array<int, EventDataRecord>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $item) => EventDataRecord::fromResponse($item),
            $response->json(),
        );
    }
}
