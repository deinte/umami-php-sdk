<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Team;
use Deinte\UmamiSdk\Dto\TeamMember;
use Deinte\UmamiSdk\Dto\Website;
use Deinte\UmamiSdk\Requests\Teams\AddTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\CreateTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\DeleteTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\DeleteTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamUsersRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamWebsitesRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamsRequest;
use Deinte\UmamiSdk\Requests\Teams\JoinTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\UpdateTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\UpdateTeamUserRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsTeamEndpoints
{
    public function teams(array $query = []): PaginatedResult
    {
        return $this->send(new GetTeamsRequest($query))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function createTeam(array $payload): Team
    {
        return $this->send(new CreateTeamRequest($payload))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function joinTeam(array $payload): TeamMember
    {
        return $this->send(new JoinTeamRequest($payload))->dto();
    }

    public function team(string $teamId): Team
    {
        return $this->send(new GetTeamRequest($teamId))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function updateTeam(string $teamId, array $payload): Team
    {
        return $this->send(new UpdateTeamRequest($teamId, $payload))->dto();
    }

    public function deleteTeam(string $teamId): bool
    {
        return $this->send(new DeleteTeamRequest($teamId))->dto();
    }

    public function teamUsers(string $teamId, array $query = []): PaginatedResult
    {
        return $this->send(new GetTeamUsersRequest($teamId, $query))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function addTeamUser(string $teamId, array $payload): TeamMember
    {
        return $this->send(new AddTeamUserRequest($teamId, $payload))->dto();
    }

    public function teamUser(string $teamId, string $userId): TeamMember
    {
        return $this->send(new GetTeamUserRequest($teamId, $userId))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function updateTeamUser(string $teamId, string $userId, array $payload): TeamMember
    {
        return $this->send(new UpdateTeamUserRequest($teamId, $userId, $payload))->dto();
    }

    public function deleteTeamUser(string $teamId, string $userId): bool
    {
        return $this->send(new DeleteTeamUserRequest($teamId, $userId))->dto();
    }

    public function teamWebsites(string $teamId, array $query = []): PaginatedResult
    {
        return $this->send(new GetTeamWebsitesRequest($teamId, $query))->dto();
    }
}
