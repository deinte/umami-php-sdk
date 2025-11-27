<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\SendResult;
use Deinte\UmamiSdk\Requests\SendingStats\SendStatsRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsSendingStats
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function sendStats(array $payload): SendResult
    {
        return $this->send(new SendStatsRequest($payload))->dto();
    }
}
