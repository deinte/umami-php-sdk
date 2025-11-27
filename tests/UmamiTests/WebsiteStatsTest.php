<?php

use Deinte\UmamiSdk\Requests\WebsiteStats\GetActiveVisitorsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetEventSeriesRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetExpandedMetricsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetMetricsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetPageviewsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetWebsiteStatsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('fetches active visitors and stats series', function () {
    MockClient::global([
        GetActiveVisitorsRequest::class => MockResponse::fixture('website-stats/active'),
        GetEventSeriesRequest::class => MockResponse::fixture('website-stats/event-series'),
    ]);

    $active = $this->umami->activeVisitors('website-1');
    $series = $this->umami->websiteEventSeries('website-1', [
        'startAt' => 0,
        'endAt' => 1,
        'unit' => 'hour',
    ]);

    expect($active->visitors)->toBe(5)
        ->and($series)->toHaveCount(2);
});

it('fetches metrics and expanded metrics', function () {
    MockClient::global([
        GetMetricsRequest::class => MockResponse::fixture('website-stats/metrics'),
        GetExpandedMetricsRequest::class => MockResponse::fixture('website-stats/expanded-metrics'),
    ]);

    $metrics = $this->umami->websiteMetrics('website-1', [
        'startAt' => 0,
        'endAt' => 1,
        'type' => 'os',
    ]);

    $expanded = $this->umami->websiteExpandedMetrics('website-1', [
        'startAt' => 0,
        'endAt' => 1,
        'type' => 'os',
    ]);

    expect($metrics[0]->dimension)->toBe('Mac OS')
        ->and($expanded[0]->visitors)->toBe(16982);
});

it('fetches pageviews and summary stats', function () {
    MockClient::global([
        GetPageviewsRequest::class => MockResponse::fixture('website-stats/pageviews'),
        GetWebsiteStatsRequest::class => MockResponse::fixture('website-stats/stats'),
    ]);

    $series = $this->umami->pageviews('website-1', [
        'startAt' => 0,
        'endAt' => 1,
        'unit' => 'day',
    ]);

    $summary = $this->umami->websiteStats('website-1', [
        'startAt' => 0,
        'endAt' => 1,
    ]);

    expect($series->pageviews)->toHaveCount(1)
        ->and($summary->pageviews)->toBe(15171);
});
