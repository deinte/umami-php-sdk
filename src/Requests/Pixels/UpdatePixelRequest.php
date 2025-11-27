<?php

namespace Deinte\UmamiSdk\Requests\Pixels;

use Deinte\UmamiSdk\Dto\Pixel;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class UpdatePixelRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected string $pixelId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/pixels/{$this->pixelId}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Pixel
    {
        return Pixel::fromResponse($response->json());
    }
}
