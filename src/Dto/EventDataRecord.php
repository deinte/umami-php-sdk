<?php

namespace Deinte\UmamiSdk\Dto;

class EventDataRecord
{
    public function __construct(
        public string $websiteId,
        public string $sessionId,
        public string $eventId,
        public string $urlPath,
        public string $eventName,
        public string $dataKey,
        public int $dataType,
        public ?string $stringValue,
        public ?float $numberValue,
        public ?string $dateValue,
        public string $createdAt,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            websiteId: $payload['websiteId'],
            sessionId: $payload['sessionId'],
            eventId: $payload['eventId'],
            urlPath: $payload['urlPath'] ?? '',
            eventName: $payload['eventName'] ?? '',
            dataKey: $payload['dataKey'],
            dataType: (int) $payload['dataType'],
            stringValue: $payload['stringValue'] ?? null,
            numberValue: isset($payload['numberValue']) ? (float) $payload['numberValue'] : null,
            dateValue: $payload['dateValue'] ?? null,
            createdAt: $payload['createdAt'],
        );
    }
}
