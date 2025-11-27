<?php

use Deinte\UmamiSdk\Requests\Admin\GetAdminTeamsRequest;
use Deinte\UmamiSdk\Requests\Admin\GetAdminUsersRequest;
use Deinte\UmamiSdk\Requests\Admin\GetAdminWebsitesRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists admin users', function () {
    MockClient::global([
        GetAdminUsersRequest::class => MockResponse::fixture('admin/users'),
    ]);

    $result = $this->umami->adminUsers();

    expect($result->items[0]->username)->toBe('member');
});

it('lists admin websites', function () {
    MockClient::global([
        GetAdminWebsitesRequest::class => MockResponse::fixture('admin/websites'),
    ]);

    $result = $this->umami->adminWebsites();

    expect($result->items)->toHaveCount(1);
});

it('lists admin teams', function () {
    MockClient::global([
        GetAdminTeamsRequest::class => MockResponse::fixture('admin/teams'),
    ]);

    $result = $this->umami->adminTeams();

    expect($result->items[0]->counts['members'])->toBe(2);
});
