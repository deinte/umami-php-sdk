<?php

namespace Deinte\UmamiSdk\Dto;

class Session
{
    public function __construct(
        public string $id,
        public string $websiteId,
        public string $hostname,
        public string $browser,
        public string $os,
        public string $device,
        public string $screen,
        public string $language,
        public string $country,
        public ?string $region = null,
        public ?string $city = null,
        public ?string $firstAt = null,
        public ?string $lastAt = null,
        public ?int $visits = null,
        public ?int $views = null,
        public ?int $events = null,
        public ?int $totalTime = null,
        public ?int $bounces = null,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            id: $payload['id'],
            websiteId: $payload['websiteId'],
            hostname: $payload['hostname'] ?? '',
            browser: $payload['browser'] ?? '',
            os: $payload['os'] ?? '',
            device: $payload['device'] ?? '',
            screen: $payload['screen'] ?? '',
            language: $payload['language'] ?? '',
            country: $payload['country'] ?? '',
            region: $payload['region'] ?? null,
            city: $payload['city'] ?? null,
            firstAt: $payload['firstAt'] ?? null,
            lastAt: $payload['lastAt'] ?? null,
            visits: $payload['visits'] ?? null,
            views: $payload['views'] ?? null,
            events: $payload['events'] ?? null,
            totalTime: $payload['totaltime'] ?? ($payload['totalTime'] ?? null),
            bounces: $payload['bounces'] ?? null,
        );
    }
}
