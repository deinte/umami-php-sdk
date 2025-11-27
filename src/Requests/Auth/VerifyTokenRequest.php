<?php

namespace Deinte\UmamiSdk\Requests\Auth;

use Deinte\UmamiSdk\Dto\VerifiedUser;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class VerifyTokenRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/auth/verify';
    }

    public function createDtoFromResponse(Response $response): VerifiedUser
    {
        return VerifiedUser::fromResponse($response->json());
    }
}
