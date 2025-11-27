<?php

use Deinte\UmamiSdk\Requests\Reports\CreateReportRequest;
use Deinte\UmamiSdk\Requests\Reports\DeleteReportRequest;
use Deinte\UmamiSdk\Requests\Reports\ExecuteReportRequest;
use Deinte\UmamiSdk\Requests\Reports\GetReportRequest;
use Deinte\UmamiSdk\Requests\Reports\GetReportsRequest;
use Deinte\UmamiSdk\Requests\Reports\UpdateReportRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('manages saved reports', function () {
    MockClient::global([
        GetReportsRequest::class => MockResponse::fixture('reports/list'),
        CreateReportRequest::class => MockResponse::fixture('reports/create'),
        GetReportRequest::class => MockResponse::fixture('reports/show'),
        UpdateReportRequest::class => MockResponse::fixture('reports/update'),
        DeleteReportRequest::class => MockResponse::fixture('reports/delete'),
    ]);

    $reports = $this->umami->reports(['websiteId' => 'website-1']);
    $report = $this->umami->createReport(['websiteId' => 'website-1', 'type' => 'goal', 'name' => 'Test']);
    $fetched = $this->umami->report($report->id);
    $updated = $this->umami->updateReport($report->id, ['name' => 'Updated Goal']);
    $deleted = $this->umami->deleteReport($report->id);

    expect($reports->items)->toHaveCount(1)
        ->and($fetched->name)->toBe('Triggered Login-button')
        ->and($updated->name)->toBe('Updated Goal')
        ->and($deleted)->toBeTrue();
});

it('runs analytical reports', function () {
    MockClient::global([
        ExecuteReportRequest::class => MockResponse::sequence(
            MockResponse::fixture('reports/attribution'),
            MockResponse::fixture('reports/breakdown'),
            MockResponse::fixture('reports/funnel'),
            MockResponse::fixture('reports/goals'),
            MockResponse::fixture('reports/journey'),
            MockResponse::fixture('reports/retention'),
            MockResponse::fixture('reports/revenue'),
            MockResponse::fixture('reports/utm'),
        ),
    ]);

    $payload = ['websiteId' => 'website-1', 'type' => 'goal', 'parameters' => []];

    $this->umami->runAttributionReport($payload);
    $this->umami->runBreakdownReport($payload);
    $this->umami->runFunnelReport($payload);
    $this->umami->runGoalsReport($payload);
    $this->umami->runJourneyReport($payload);
    $this->umami->runRetentionReport($payload);
    $this->umami->runRevenueReport($payload);
    $this->umami->runUtmReport($payload);

    expect(true)->toBeTrue();
});
