<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Team;
use Deinte\UmamiSdk\Dto\User;
use Deinte\UmamiSdk\Dto\Website;
use Deinte\UmamiSdk\Requests\Users\CreateUserRequest;
use Deinte\UmamiSdk\Requests\Users\DeleteUserRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserTeamsRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserWebsitesRequest;
use Deinte\UmamiSdk\Requests\Users\UpdateUserRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsUserEndpoints
{
    /**
     * @param array<string, mixed> $payload
     */
    public function createUser(array $payload): User
    {
        return $this->send(new CreateUserRequest($payload))->dto();
    }

    public function user(string $userId): User
    {
        return $this->send(new GetUserRequest($userId))->dto();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function updateUser(string $userId, array $payload): User
    {
        return $this->send(new UpdateUserRequest($userId, $payload))->dto();
    }

    public function deleteUser(string $userId): bool
    {
        return $this->send(new DeleteUserRequest($userId))->dto();
    }

    /**
     * @return PaginatedResult<Website>
     */
    public function userWebsites(string $userId, array $query = []): PaginatedResult
    {
        return $this->send(new GetUserWebsitesRequest($userId, $query))->dto();
    }

    /**
     * @return PaginatedResult<Team>
     */
    public function userTeams(string $userId, array $query = []): PaginatedResult
    {
        return $this->send(new GetUserTeamsRequest($userId, $query))->dto();
    }
}
