<?php

namespace Deinte\UmamiSdk\Dto;

class PageviewSeries
{
    /**
     * @param array<int, TimeSeriesPoint> $pageviews
     * @param array<int, TimeSeriesPoint> $sessions
     */
    public function __construct(
        public array $pageviews,
        public array $sessions,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        $pageviews = array_map(
            fn (array $point) => TimeSeriesPoint::fromResponse($point),
            $payload['pageviews'] ?? [],
        );

        $sessions = array_map(
            fn (array $point) => TimeSeriesPoint::fromResponse($point),
            $payload['sessions'] ?? [],
        );

        return new self($pageviews, $sessions);
    }
}
