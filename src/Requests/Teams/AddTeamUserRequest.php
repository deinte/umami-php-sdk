<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Deinte\UmamiSdk\Dto\TeamMember;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class AddTeamUserRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected string $teamId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}/users";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): TeamMember
    {
        return TeamMember::fromResponse($response->json());
    }
}
