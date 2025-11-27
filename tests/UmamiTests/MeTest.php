<?php

use Deinte\UmamiSdk\Requests\Me\GetMeRequest;
use Deinte\UmamiSdk\Requests\Me\GetMyTeamsRequest;
use Deinte\UmamiSdk\Requests\Me\GetMyWebsitesRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('fetches the current session details', function () {
    MockClient::global([
        GetMeRequest::class => MockResponse::fixture('me/get-me'),
    ]);

    $session = $this->umami->me();

    expect($session->token)->toBe('sample-token')
        ->and($session->user->username)->toBe('member');
});

it('lists my teams', function () {
    MockClient::global([
        GetMyTeamsRequest::class => MockResponse::fixture('me/my-teams'),
    ]);

    $teams = $this->umami->myTeams();

    expect($teams->count)->toBe(1)
        ->and($teams->items[0]->members[0]->role)->toBe('team-owner');
});

it('lists my websites including user info', function () {
    MockClient::global([
        GetMyWebsitesRequest::class => MockResponse::fixture('me/my-websites'),
    ]);

    $websites = $this->umami->myWebsites();

    expect($websites->items)->toHaveCount(1)
        ->and($websites->items[0]->domain)->toBe('docs.example.com')
        ->and($websites->items[0]->user?->username)->toBe('admin');
});
