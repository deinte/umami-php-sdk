<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\SessionContext;
use Deinte\UmamiSdk\Requests\Me\GetMeRequest;
use Deinte\UmamiSdk\Requests\Me\GetMyTeamsRequest;
use Deinte\UmamiSdk\Requests\Me\GetMyWebsitesRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsMeEndpoints
{
    public function me(): SessionContext
    {
        return $this->send(new GetMeRequest())->dto();
    }

    public function myTeams(array $query = []): PaginatedResult
    {
        return $this->send(new GetMyTeamsRequest($query))->dto();
    }

    public function myWebsites(bool $includeTeams = false): PaginatedResult
    {
        return $this->send(new GetMyWebsitesRequest($includeTeams))->dto();
    }
}
