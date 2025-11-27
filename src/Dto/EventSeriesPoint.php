<?php

namespace Deinte\UmamiSdk\Dto;

class EventSeriesPoint
{
    public function __construct(
        public string $name,
        public string $timestamp,
        public int $count,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            name: $payload['x'],
            timestamp: $payload['t'],
            count: (int) $payload['y'],
        );
    }
}
