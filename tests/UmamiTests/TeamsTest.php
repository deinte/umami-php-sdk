<?php

use Deinte\UmamiSdk\Requests\Teams\AddTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\CreateTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\DeleteTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\DeleteTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamsRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamUserRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamUsersRequest;
use Deinte\UmamiSdk\Requests\Teams\GetTeamWebsitesRequest;
use Deinte\UmamiSdk\Requests\Teams\JoinTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\UpdateTeamRequest;
use Deinte\UmamiSdk\Requests\Teams\UpdateTeamUserRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists and creates teams', function () {
    MockClient::global([
        GetTeamsRequest::class => MockResponse::fixture('teams/list'),
        CreateTeamRequest::class => MockResponse::fixture('teams/create'),
        JoinTeamRequest::class => MockResponse::fixture('teams/join'),
    ]);

    $teams = $this->umami->teams();
    $team = $this->umami->createTeam(['name' => 'Marketing']);
    $member = $this->umami->joinTeam(['accessCode' => 'team_xyz']);

    expect($teams->items)->toHaveCount(1)
        ->and($team->name)->toBe('Marketing')
        ->and($member->role)->toBe('team-member');
});

it('updates and deletes a team', function () {
    MockClient::global([
        GetTeamRequest::class => MockResponse::fixture('teams/show'),
        UpdateTeamRequest::class => MockResponse::fixture('teams/update'),
        DeleteTeamRequest::class => MockResponse::fixture('teams/delete'),
    ]);

    $team = $this->umami->team('team-2');
    $updated = $this->umami->updateTeam($team->id, ['name' => 'Marketing Ops']);
    $deleted = $this->umami->deleteTeam($team->id);

    expect($updated->name)->toBe('Marketing Ops')
        ->and($deleted)->toBeTrue();
});

it('manages team members', function () {
    MockClient::global([
        GetTeamUsersRequest::class => MockResponse::fixture('teams/users'),
        AddTeamUserRequest::class => MockResponse::fixture('teams/add-user'),
        GetTeamUserRequest::class => MockResponse::fixture('teams/team-user'),
        UpdateTeamUserRequest::class => MockResponse::fixture('teams/team-user'),
        DeleteTeamUserRequest::class => MockResponse::fixture('teams/delete-user'),
    ]);

    $members = $this->umami->teamUsers('team-2');
    $newMember = $this->umami->addTeamUser('team-2', ['userId' => 'user-4', 'role' => 'team-member']);
    $member = $this->umami->teamUser('team-2', $newMember->userId);
    $updated = $this->umami->updateTeamUser('team-2', $member->userId, ['role' => 'team-manager']);
    $deleted = $this->umami->deleteTeamUser('team-2', $member->userId);

    expect($members->count)->toBe(1)
        ->and($updated->role)->toBe('team-manager')
        ->and($deleted)->toBeTrue();
});

it('lists team websites', function () {
    MockClient::global([
        GetTeamWebsitesRequest::class => MockResponse::fixture('teams/websites'),
    ]);

    $websites = $this->umami->teamWebsites('team-2');

    expect($websites->items[0]->domain)->toBe('team.example.com');
});
