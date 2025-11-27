<?php

namespace Deinte\UmamiSdk\Dto;

class ActiveVisitors
{
    public function __construct(
        public int $visitors,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(visitors: (int) ($payload['visitors'] ?? 0));
    }
}
