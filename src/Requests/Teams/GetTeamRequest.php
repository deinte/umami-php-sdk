<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Deinte\UmamiSdk\Dto\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $teamId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}";
    }

    public function createDtoFromResponse(Response $response): Team
    {
        return Team::fromResponse($response->json());
    }
}
