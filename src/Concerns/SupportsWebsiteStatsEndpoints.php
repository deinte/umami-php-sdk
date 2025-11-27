<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\ActiveVisitors;
use Deinte\UmamiSdk\Dto\EventSeriesPoint;
use Deinte\UmamiSdk\Dto\ExpandedMetric;
use Deinte\UmamiSdk\Dto\MetricPoint;
use Deinte\UmamiSdk\Dto\PageviewSeries;
use Deinte\UmamiSdk\Dto\WebsiteStatsSummary;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetActiveVisitorsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetEventSeriesRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetExpandedMetricsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetMetricsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetPageviewsRequest;
use Deinte\UmamiSdk\Requests\WebsiteStats\GetWebsiteStatsRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsWebsiteStatsEndpoints
{
    public function activeVisitors(string $websiteId): ActiveVisitors
    {
        return $this->send(new GetActiveVisitorsRequest($websiteId))->dto();
    }

    /**
     * @return array<int, EventSeriesPoint>
     */
    public function websiteEventSeries(string $websiteId, array $query): array
    {
        return $this->send(new GetEventSeriesRequest($websiteId, $query))->dto();
    }

    /**
     * @return array<int, MetricPoint>
     */
    public function websiteMetrics(string $websiteId, array $query): array
    {
        return $this->send(new GetMetricsRequest($websiteId, $query))->dto();
    }

    /**
     * @return array<int, ExpandedMetric>
     */
    public function websiteExpandedMetrics(string $websiteId, array $query): array
    {
        return $this->send(new GetExpandedMetricsRequest($websiteId, $query))->dto();
    }

    public function pageviews(string $websiteId, array $query): PageviewSeries
    {
        return $this->send(new GetPageviewsRequest($websiteId, $query))->dto();
    }

    public function websiteStats(string $websiteId, array $query): WebsiteStatsSummary
    {
        return $this->send(new GetWebsiteStatsRequest($websiteId, $query))->dto();
    }
}
