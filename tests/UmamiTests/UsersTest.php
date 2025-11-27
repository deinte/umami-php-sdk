<?php

use Deinte\UmamiSdk\Requests\Users\CreateUserRequest;
use Deinte\UmamiSdk\Requests\Users\DeleteUserRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserTeamsRequest;
use Deinte\UmamiSdk\Requests\Users\GetUserWebsitesRequest;
use Deinte\UmamiSdk\Requests\Users\UpdateUserRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('creates and updates a user', function () {
    MockClient::global([
        CreateUserRequest::class => MockResponse::fixture('users/create'),
        UpdateUserRequest::class => MockResponse::fixture('users/update'),
    ]);

    $user = $this->umami->createUser([
        'username' => 'member',
        'password' => 'secret',
        'role' => 'user',
    ]);

    expect($user->role)->toBe('user');

    $updated = $this->umami->updateUser($user->id, ['role' => 'admin']);

    expect($updated->role)->toBe('admin');
});

it('fetches user details and websites', function () {
    MockClient::global([
        GetUserRequest::class => MockResponse::fixture('users/show'),
        GetUserWebsitesRequest::class => MockResponse::fixture('users/websites'),
    ]);

    $user = $this->umami->user('user-2');
    $websites = $this->umami->userWebsites($user->id);

    expect($websites->items)->toHaveCount(1);
});

it('lists user teams and deletes user', function () {
    MockClient::global([
        GetUserTeamsRequest::class => MockResponse::fixture('users/teams'),
        DeleteUserRequest::class => MockResponse::fixture('users/delete'),
    ]);

    $teams = $this->umami->userTeams('user-2');
    $deleted = $this->umami->deleteUser('user-2');

    expect($teams->items[0]->name)->toBe('Marketing')
        ->and($deleted)->toBeTrue();
});
