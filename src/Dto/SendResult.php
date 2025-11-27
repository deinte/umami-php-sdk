<?php

namespace Deinte\UmamiSdk\Dto;

class SendResult
{
    public function __construct(
        public ?string $cache,
        public ?string $sessionId,
        public ?string $visitId,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            cache: $payload['cache'] ?? null,
            sessionId: $payload['sessionId'] ?? null,
            visitId: $payload['visitId'] ?? null,
        );
    }
}
