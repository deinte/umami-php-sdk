<?php

namespace Deinte\UmamiSdk\Requests\Links;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeleteLinkRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $linkId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/links/{$this->linkId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
