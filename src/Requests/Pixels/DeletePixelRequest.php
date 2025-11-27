<?php

namespace Deinte\UmamiSdk\Requests\Pixels;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeletePixelRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $pixelId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/pixels/{$this->pixelId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
