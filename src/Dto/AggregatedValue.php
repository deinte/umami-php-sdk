<?php

namespace Deinte\UmamiSdk\Dto;

class AggregatedValue
{
    public function __construct(
        public string $name,
        public int $total,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            name: $payload['propertyName'] ?? ($payload['value'] ?? ''),
            total: (int) $payload['total'],
        );
    }
}
