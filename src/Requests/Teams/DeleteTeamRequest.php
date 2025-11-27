<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeleteTeamRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $teamId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
