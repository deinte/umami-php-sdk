<?php

namespace Deinte\UmamiSdk\Dto;

class MetricPoint
{
    public function __construct(
        public string $dimension,
        public int $count,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            dimension: $payload['x'],
            count: (int) $payload['y'],
        );
    }
}
