<?php

namespace Deinte\UmamiSdk\Requests\Links;

use Deinte\UmamiSdk\Dto\Link;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLinkRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $linkId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/links/{$this->linkId}";
    }

    public function createDtoFromResponse(Response $response): Link
    {
        return Link::fromResponse($response->json());
    }
}
