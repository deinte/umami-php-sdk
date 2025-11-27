<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeleteTeamUserRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $teamId,
        protected string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}/users/{$this->userId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
