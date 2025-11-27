<?php

namespace Deinte\UmamiSdk\Dto;

class RealtimeSnapshot
{
    public function __construct(
        public array $countries,
        public array $urls,
        public array $referrers,
        public array $events,
        public array $series,
        public array $totals,
        public int $timestamp,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            countries: $payload['countries'] ?? [],
            urls: $payload['urls'] ?? [],
            referrers: $payload['referrers'] ?? [],
            events: $payload['events'] ?? [],
            series: $payload['series'] ?? [],
            totals: $payload['totals'] ?? [],
            timestamp: (int) ($payload['timestamp'] ?? 0),
        );
    }
}
