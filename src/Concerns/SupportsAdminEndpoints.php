<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Requests\Admin\GetAdminTeamsRequest;
use Deinte\UmamiSdk\Requests\Admin\GetAdminUsersRequest;
use Deinte\UmamiSdk\Requests\Admin\GetAdminWebsitesRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsAdminEndpoints
{
    public function adminUsers(array $query = []): PaginatedResult
    {
        return $this->send(new GetAdminUsersRequest($query))->dto();
    }

    public function adminWebsites(array $query = []): PaginatedResult
    {
        return $this->send(new GetAdminWebsitesRequest($query))->dto();
    }

    public function adminTeams(array $query = []): PaginatedResult
    {
        return $this->send(new GetAdminTeamsRequest($query))->dto();
    }
}
