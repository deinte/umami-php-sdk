<?php

use Deinte\UmamiSdk\Requests\SendingStats\SendStatsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('sends custom stats payload', function () {
    MockClient::global([
        SendStatsRequest::class => MockResponse::fixture('sending-stats/send'),
    ]);

    $result = $this->umami->sendStats([
        'payload' => ['website' => 'website-1', 'name' => 'event'],
        'type' => 'event',
    ]);

    expect($result->sessionId)->toBe('session-1');
});
