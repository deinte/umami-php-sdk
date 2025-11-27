<?php

namespace Deinte\UmamiSdk\Dto;

class EventDataAggregate
{
    public function __construct(
        public string $eventName,
        public string $propertyName,
        public int $dataType,
        public int $total,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            eventName: $payload['eventName'] ?? '',
            propertyName: $payload['propertyName'] ?? '',
            dataType: (int) $payload['dataType'],
            total: (int) $payload['total'],
        );
    }
}
