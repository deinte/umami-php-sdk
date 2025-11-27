<?php

use Deinte\UmamiSdk\Requests\Realtime\GetRealtimeRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('fetches realtime snapshot', function () {
    MockClient::global([
        GetRealtimeRequest::class => MockResponse::fixture('realtime/show'),
    ]);

    $snapshot = $this->umami->realtime('website-1');

    expect($snapshot->totals['views'])->toBe(69);
});
