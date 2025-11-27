<?php

namespace Deinte\UmamiSdk\Dto;

class EventDataStats
{
    public function __construct(
        public int $events,
        public int $properties,
        public int $records,
    ) {}

    /**
     * @param  array<int, array<string, mixed>>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        $item = $payload[0] ?? ['events' => 0, 'properties' => 0, 'records' => 0];

        return new self(
            events: (int) ($item['events'] ?? 0),
            properties: (int) ($item['properties'] ?? 0),
            records: (int) ($item['records'] ?? 0),
        );
    }
}
