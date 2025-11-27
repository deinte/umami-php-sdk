<?php

use Deinte\UmamiSdk\Requests\Sessions\GetSessionActivityRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionDataPropertiesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionDataValuesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionPropertiesRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionStatsRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionWeeklyRequest;
use Deinte\UmamiSdk\Requests\Sessions\GetSessionsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists sessions and fetches stats', function () {
    MockClient::global([
        GetSessionsRequest::class => MockResponse::fixture('sessions/list'),
        GetSessionStatsRequest::class => MockResponse::fixture('sessions/stats'),
        GetSessionWeeklyRequest::class => MockResponse::fixture('sessions/weekly'),
    ]);

    $sessions = $this->umami->sessions('website-1', ['startAt' => 0, 'endAt' => 1]);
    $stats = $this->umami->sessionStats('website-1', ['startAt' => 0, 'endAt' => 1]);
    $weekly = $this->umami->weeklySessions('website-1', ['startAt' => 0, 'endAt' => 1, 'timezone' => 'UTC']);

    expect($sessions->items)->toHaveCount(1)
        ->and($stats->pageviews['value'])->toBe(2924)
        ->and($weekly)->toHaveCount(3);
});

it('shows session detail and activity', function () {
    MockClient::global([
        GetSessionRequest::class => MockResponse::fixture('sessions/show'),
        GetSessionActivityRequest::class => MockResponse::fixture('sessions/activity'),
        GetSessionPropertiesRequest::class => MockResponse::fixture('sessions/properties'),
    ]);

    $session = $this->umami->session('website-1', 'session-1');
    $activity = $this->umami->sessionActivity('website-1', 'session-1', ['startAt' => 0, 'endAt' => 1]);
    $properties = $this->umami->sessionProperties('website-1', 'session-1');

    expect($session->visits)->toBe(2)
        ->and($activity)->toHaveCount(1)
        ->and($properties[0]->dataKey)->toBe('email');
});

it('fetches session data aggregations', function () {
    MockClient::global([
        GetSessionDataPropertiesRequest::class => MockResponse::fixture('sessions/session-data-properties'),
        GetSessionDataValuesRequest::class => MockResponse::fixture('sessions/session-data-values'),
    ]);

    $properties = $this->umami->sessionDataProperties('website-1', ['startAt' => 0, 'endAt' => 1]);
    $values = $this->umami->sessionDataValues('website-1', ['startAt' => 0, 'endAt' => 1, 'propertyName' => 'region']);

    expect($properties[0]->name)->toBe('email')
        ->and($values[0]->name)->toBe('US');
});
