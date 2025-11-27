<?php

use Deinte\UmamiSdk\Requests\Websites\CreateWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\DeleteWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\GetWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\GetWebsitesRequest;
use Deinte\UmamiSdk\Requests\Websites\ResetWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\UpdateWebsiteRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists websites', function () {
    MockClient::global([
        GetWebsitesRequest::class => MockResponse::fixture('websites/list'),
    ]);

    $result = $this->umami->websites();

    expect($result->items)->toHaveCount(1)
        ->and($result->items[0]->name)->toBe('Example');
});

it('shows a specific website', function () {
    MockClient::global([
        GetWebsiteRequest::class => MockResponse::fixture('websites/show'),
    ]);

    $website = $this->umami->website('website-1');

    expect($website->domain)->toBe('example.com');
});

it('creates a website', function () {
    MockClient::global([
        CreateWebsiteRequest::class => MockResponse::fixture('websites/create'),
    ]);

    $website = $this->umami->createWebsite([
        'name' => 'New Site',
        'domain' => 'new.example.com',
    ]);

    expect($website->shareId)->toBe('share-abc');
});

it('updates a website', function () {
    MockClient::global([
        UpdateWebsiteRequest::class => MockResponse::fixture('websites/update'),
    ]);

    $website = $this->umami->updateWebsite('website-2', [
        'name' => 'Updated Site',
    ]);

    expect($website->name)->toBe('Updated Site');
});

it('deletes a website', function () {
    MockClient::global([
        DeleteWebsiteRequest::class => MockResponse::make([], 200),
    ]);

    $result = $this->umami->deleteWebsite('website-2');

    expect($result)->toBeTrue();
});

it('resets a website', function () {
    MockClient::global([
        ResetWebsiteRequest::class => MockResponse::fixture('websites/reset'),
    ]);

    $result = $this->umami->resetWebsite('website-1');

    expect($result)->toBeTrue();
});
