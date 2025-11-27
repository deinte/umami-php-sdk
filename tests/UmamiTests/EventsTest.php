<?php

use Deinte\UmamiSdk\Requests\Events\GetEventDataEventsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataFieldsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataPropertiesRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataStatsRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventDataValuesRequest;
use Deinte\UmamiSdk\Requests\Events\GetEventsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('lists events and event-data records', function () {
    MockClient::global([
        GetEventsRequest::class => MockResponse::fixture('events/list'),
        GetEventDataRequest::class => MockResponse::fixture('events/event-data'),
    ]);

    $events = $this->umami->events('website-1', ['startAt' => 0, 'endAt' => 1]);
    $records = $this->umami->eventData('website-1', 'event-1');

    expect($events->items)->toHaveCount(1)
        ->and($records)->toHaveCount(2);
});

it('fetches event aggregates and stats', function () {
    MockClient::global([
        GetEventDataEventsRequest::class => MockResponse::fixture('events/event-data-events'),
        GetEventDataFieldsRequest::class => MockResponse::fixture('events/event-data-fields'),
        GetEventDataPropertiesRequest::class => MockResponse::fixture('events/event-data-properties'),
        GetEventDataValuesRequest::class => MockResponse::fixture('events/event-data-values'),
        GetEventDataStatsRequest::class => MockResponse::fixture('events/event-data-stats'),
    ]);

    $events = $this->umami->eventDataEvents('website-1', ['startAt' => 0, 'endAt' => 1]);
    $fields = $this->umami->eventDataFields('website-1', ['startAt' => 0, 'endAt' => 1]);
    $properties = $this->umami->eventDataProperties('website-1', ['startAt' => 0, 'endAt' => 1]);
    $values = $this->umami->eventDataValues('website-1', ['startAt' => 0, 'endAt' => 1, 'event' => 'signup', 'propertyName' => 'gender']);
    $stats = $this->umami->eventDataStats('website-1', ['startAt' => 0, 'endAt' => 1]);

    expect($events[0]->eventName)->toBe('button-click')
        ->and($fields[0]->name)->toBe('age')
        ->and($properties[0]->propertyName)->toBe('revenue')
        ->and($values[0]->name)->toBe('Male')
        ->and($stats->records)->toBe(26);
});
