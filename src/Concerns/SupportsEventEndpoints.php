<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\EventRecord;
use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Requests\Events\GetEventDataEventsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataFieldsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataPropertiesRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataStatsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataValuesRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventsRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsEventEndpoints
{
    /**
     * @return PaginatedResult<EventRecord>
     */
    public function events(string $websiteId, array $query): PaginatedResult
    {
        return $this->send(new GetEventsRequest($websiteId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\EventDataRecord> */
    public function eventData(string $websiteId, string $eventId): array
    {
        return $this->send(new GetEventDataRequest($websiteId, $eventId))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\EventDataAggregate> */
    public function eventDataEvents(string $websiteId, array $query): array
    {
        return $this->send(new GetEventDataEventsRequest($websiteId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\AggregatedValue> */
    public function eventDataFields(string $websiteId, array $query): array
    {
        return $this->send(new GetEventDataFieldsRequest($websiteId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\EventDataAggregate> */
    public function eventDataProperties(string $websiteId, array $query): array
    {
        return $this->send(new GetEventDataPropertiesRequest($websiteId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\AggregatedValue> */
    public function eventDataValues(string $websiteId, array $query): array
    {
        return $this->send(new GetEventDataValuesRequest($websiteId, $query))->dto();
    }

    public function eventDataStats(string $websiteId, array $query): \Deinte\UmamiSdk\Dto\EventDataStats
    {
        return $this->send(new GetEventDataStatsRequest($websiteId, $query))->dto();
    }
}
