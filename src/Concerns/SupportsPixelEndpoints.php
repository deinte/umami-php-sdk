<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Pixel;
use Deinte\UmamiSdk\Requests\Pixels\DeletePixelRequest;
use Deinte\UmamiSdk\Requests\Pixels\GetPixelRequest;
use Deinte\UmamiSdk\Requests\Pixels\GetPixelsRequest;
use Deinte\UmamiSdk\Requests\Pixels\UpdatePixelRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsPixelEndpoints
{
    public function pixels(array $query = []): PaginatedResult
    {
        return $this->send(new GetPixelsRequest($query))->dto();
    }

    public function pixel(string $pixelId): Pixel
    {
        return $this->send(new GetPixelRequest($pixelId))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function updatePixel(string $pixelId, array $payload): Pixel
    {
        return $this->send(new UpdatePixelRequest($pixelId, $payload))->dto();
    }

    public function deletePixel(string $pixelId): bool
    {
        return $this->send(new DeletePixelRequest($pixelId))->dto();
    }
}
