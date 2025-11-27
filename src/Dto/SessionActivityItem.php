<?php

namespace Deinte\UmamiSdk\Dto;

class SessionActivityItem
{
    public function __construct(
        public string $createdAt,
        public string $urlPath,
        public string $urlQuery,
        public string $referrerDomain,
        public string $eventId,
        public int $eventType,
        public string $eventName,
        public string $visitId,
        public bool $hasData,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            createdAt: $payload['createdAt'],
            urlPath: $payload['urlPath'] ?? '',
            urlQuery: $payload['urlQuery'] ?? '',
            referrerDomain: $payload['referrerDomain'] ?? '',
            eventId: $payload['eventId'],
            eventType: (int) $payload['eventType'],
            eventName: $payload['eventName'] ?? '',
            visitId: $payload['visitId'],
            hasData: (bool) $payload['hasData'],
        );
    }
}
