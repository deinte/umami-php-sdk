<?php

namespace Deinte\UmamiSdk\Dto;

class TimeSeriesPoint
{
    public function __construct(
        public string $timestamp,
        public int $value,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            timestamp: $payload['x'],
            value: (int) $payload['y'],
        );
    }
}
