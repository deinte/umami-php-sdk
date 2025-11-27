<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\RealtimeSnapshot;
use Deinte\UmamiSdk\Requests\Realtime\GetRealtimeRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsRealtimeEndpoints
{
    public function realtime(string $websiteId): RealtimeSnapshot
    {
        return $this->send(new GetRealtimeRequest($websiteId))->dto();
    }
}
