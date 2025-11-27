<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Report;
use Deinte\UmamiSdk\Requests\Reports\CreateReportRequest;
use Deinte\UmamiSdk\Requests\Reports\DeleteReportRequest;
use Deinte\UmamiSdk\Requests\Reports\ExecuteReportRequest;
use Deinte\UmamiSdk\Requests\Reports\GetReportRequest;
use Deinte\UmamiSdk\Requests\Reports\GetReportsRequest;
use Deinte\UmamiSdk\Requests\Reports\UpdateReportRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsReportEndpoints
{
    public function reports(array $query): PaginatedResult
    {
        return $this->send(new GetReportsRequest($query))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function createReport(array $payload): Report
    {
        return $this->send(new CreateReportRequest($payload))->dto();
    }

    public function report(string $reportId): Report
    {
        return $this->send(new GetReportRequest($reportId))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function updateReport(string $reportId, array $payload): Report
    {
        return $this->send(new UpdateReportRequest($reportId, $payload))->dto();
    }

    public function deleteReport(string $reportId): bool
    {
        return $this->send(new DeleteReportRequest($reportId))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function runAttributionReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('attribution', $payload))->dto();
    }

    public function runBreakdownReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('breakdown', $payload))->dto();
    }

    public function runFunnelReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('funnel', $payload))->dto();
    }

    public function runGoalsReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('goals', $payload))->dto();
    }

    public function runJourneyReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('journey', $payload))->dto();
    }

    public function runRetentionReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('retention', $payload))->dto();
    }

    public function runRevenueReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('revenue', $payload))->dto();
    }

    public function runUtmReport(array $payload): array
    {
        return $this->send(new ExecuteReportRequest('utm', $payload))->dto();
    }
}
