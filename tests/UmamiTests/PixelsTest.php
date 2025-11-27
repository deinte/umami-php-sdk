<?php

use Deinte\UmamiSdk\Requests\Pixels\DeletePixelRequest;
use Deinte\UmamiSdk\Requests\Pixels\GetPixelRequest;
use Deinte\UmamiSdk\Requests\Pixels\GetPixelsRequest;
use Deinte\UmamiSdk\Requests\Pixels\UpdatePixelRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists and updates pixels', function () {
    MockClient::global([
        GetPixelsRequest::class => MockResponse::fixture('pixels/list'),
        GetPixelRequest::class => MockResponse::fixture('pixels/show'),
        UpdatePixelRequest::class => MockResponse::fixture('pixels/update'),
        DeletePixelRequest::class => MockResponse::fixture('pixels/delete'),
    ]);

    $pixels = $this->umami->pixels();
    $pixel = $this->umami->pixel('pixel-1');
    $updated = $this->umami->updatePixel('pixel-1', ['name' => 'Updated Pixel']);
    $deleted = $this->umami->deletePixel('pixel-1');

    expect($pixels->items)->toHaveCount(1)
        ->and($pixel->name)->toBe('Umami Pixel')
        ->and($updated->name)->toBe('Updated Pixel')
        ->and($deleted)->toBeTrue();
});
