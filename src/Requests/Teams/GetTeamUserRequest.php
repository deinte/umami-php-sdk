<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Deinte\UmamiSdk\Dto\TeamMember;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $teamId,
        protected string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}/users/{$this->userId}";
    }

    public function createDtoFromResponse(Response $response): TeamMember
    {
        return TeamMember::fromResponse($response->json());
    }
}
