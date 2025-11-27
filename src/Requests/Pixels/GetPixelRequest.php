<?php

namespace Deinte\UmamiSdk\Requests\Pixels;

use Deinte\UmamiSdk\Dto\Pixel;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPixelRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $pixelId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/pixels/{$this->pixelId}";
    }

    public function createDtoFromResponse(Response $response): Pixel
    {
        return Pixel::fromResponse($response->json());
    }
}
