<?php

namespace Deinte\UmamiSdk\Dto;

class SessionStats
{
    public function __construct(
        public array $pageviews,
        public array $visitors,
        public array $visits,
        public array $countries,
        public array $events,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            pageviews: $payload['pageviews'] ?? [],
            visitors: $payload['visitors'] ?? [],
            visits: $payload['visits'] ?? [],
            countries: $payload['countries'] ?? [],
            events: $payload['events'] ?? [],
        );
    }
}
