<?php

namespace Deinte\UmamiSdk\Dto;

class EventRecord
{
    public function __construct(
        public string $id,
        public string $websiteId,
        public string $sessionId,
        public string $createdAt,
        public string $hostname,
        public string $urlPath,
        public string $urlQuery,
        public string $referrerPath,
        public string $referrerQuery,
        public string $referrerDomain,
        public string $country,
        public string $city,
        public string $device,
        public string $os,
        public string $browser,
        public string $pageTitle,
        public int $eventType,
        public string $eventName,
        public bool $hasData,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            id: $payload['id'],
            websiteId: $payload['websiteId'],
            sessionId: $payload['sessionId'],
            createdAt: $payload['createdAt'],
            hostname: $payload['hostname'] ?? '',
            urlPath: $payload['urlPath'] ?? '',
            urlQuery: $payload['urlQuery'] ?? '',
            referrerPath: $payload['referrerPath'] ?? '',
            referrerQuery: $payload['referrerQuery'] ?? '',
            referrerDomain: $payload['referrerDomain'] ?? '',
            country: $payload['country'] ?? '',
            city: $payload['city'] ?? '',
            device: $payload['device'] ?? '',
            os: $payload['os'] ?? '',
            browser: $payload['browser'] ?? '',
            pageTitle: $payload['pageTitle'] ?? '',
            eventType: (int) $payload['eventType'],
            eventName: $payload['eventName'] ?? '',
            hasData: (bool) $payload['hasData'],
        );
    }
}
