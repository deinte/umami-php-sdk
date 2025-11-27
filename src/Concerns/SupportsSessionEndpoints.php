<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Session;
use Deinte\UmamiSdk\Dto\SessionStats;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionActivityRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionDataPropertiesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionDataValuesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionPropertiesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionStatsRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionWeeklyRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionsRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsSessionEndpoints
{
    /**
     * @return PaginatedResult<Session>
     */
    public function sessions(string $websiteId, array $query): PaginatedResult
    {
        return $this->send(new GetSessionsRequest($websiteId, $query))->dto();
    }

    public function sessionStats(string $websiteId, array $query): SessionStats
    {
        return $this->send(new GetSessionStatsRequest($websiteId, $query))->dto();
    }

    /** @return array<int, array<int, int>> */
    public function weeklySessions(string $websiteId, array $query): array
    {
        return $this->send(new GetSessionWeeklyRequest($websiteId, $query))->dto();
    }

    public function session(string $websiteId, string $sessionId): Session
    {
        return $this->send(new GetSessionRequest($websiteId, $sessionId))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\SessionActivityItem> */
    public function sessionActivity(string $websiteId, string $sessionId, array $query): array
    {
        return $this->send(new GetSessionActivityRequest($websiteId, $sessionId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\SessionPropertyRecord> */
    public function sessionProperties(string $websiteId, string $sessionId): array
    {
        return $this->send(new GetSessionPropertiesRequest($websiteId, $sessionId))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\AggregatedValue> */
    public function sessionDataProperties(string $websiteId, array $query): array
    {
        return $this->send(new GetSessionDataPropertiesRequest($websiteId, $query))->dto();
    }

    /** @return array<int, \Deinte\UmamiSdk\Dto\AggregatedValue> */
    public function sessionDataValues(string $websiteId, array $query): array
    {
        return $this->send(new GetSessionDataValuesRequest($websiteId, $query))->dto();
    }
}
