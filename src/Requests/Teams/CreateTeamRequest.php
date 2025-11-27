<?php

namespace Deinte\UmamiSdk\Requests\Teams;

use Deinte\UmamiSdk\Dto\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class CreateTeamRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/teams';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Team
    {
        if (array_is_list($response->json())) {
            $data = $response->json()[0] ?? [];
        } else {
            $data = $response->json();
        }

        return Team::fromResponse($data);
    }
}
