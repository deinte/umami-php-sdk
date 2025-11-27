<?php

namespace Deinte\UmamiSdk\Dto;

class ExpandedMetric
{
    public function __construct(
        public string $name,
        public int $pageviews,
        public int $visitors,
        public int $visits,
        public int $bounces,
        public int $totalTime,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            name: $payload['name'],
            pageviews: (int) ($payload['pageviews'] ?? 0),
            visitors: (int) ($payload['visitors'] ?? 0),
            visits: (int) ($payload['visits'] ?? 0),
            bounces: (int) ($payload['bounces'] ?? 0),
            totalTime: (int) ($payload['totaltime'] ?? 0),
        );
    }
}
