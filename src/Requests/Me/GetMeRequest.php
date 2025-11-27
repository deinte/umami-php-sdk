<?php

namespace Deinte\UmamiSdk\Requests\Me;

use Deinte\UmamiSdk\Dto\SessionContext;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMeRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/me';
    }

    public function createDtoFromResponse(Response $response): SessionContext
    {
        return SessionContext::fromResponse($response->json());
    }
}
