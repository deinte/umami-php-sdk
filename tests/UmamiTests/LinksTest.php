<?php

use Deinte\UmamiSdk\Requests\Links\DeleteLinkRequest;
use Deinte\UmamiSdk\Requests\Links\GetLinkRequest;
use Deinte\UmamiSdk\Requests\Links\GetLinksRequest;
use Deinte\UmamiSdk\Requests\Links\UpdateLinkRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists and updates links', function () {
    MockClient::global([
        GetLinksRequest::class => MockResponse::fixture('links/list'),
        GetLinkRequest::class => MockResponse::fixture('links/show'),
        UpdateLinkRequest::class => MockResponse::fixture('links/update'),
        DeleteLinkRequest::class => MockResponse::fixture('links/delete'),
    ]);

    $links = $this->umami->links();
    $link = $this->umami->link('link-1');
    $updated = $this->umami->updateLink('link-1', ['name' => 'umami blog']);
    $deleted = $this->umami->deleteLink('link-1');

    expect($links->items)->toHaveCount(1)
        ->and($link->name)->toBe('umami')
        ->and($updated->name)->toBe('umami blog')
        ->and($deleted)->toBeTrue();
});
