<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Dto\Website;
use Deinte\UmamiSdk\Requests\Websites\CreateWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\DeleteWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\GetWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\GetWebsitesRequest;
use Deinte\UmamiSdk\Requests\Websites\ResetWebsiteRequest;
use Deinte\UmamiSdk\Requests\Websites\UpdateWebsiteRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsWebsiteEndpoints
{
    public function websites(array $query = []): PaginatedResult
    {
        return $this->send(new GetWebsitesRequest($query))->dto();
    }

    public function website(string $websiteId): Website
    {
        return $this->send(new GetWebsiteRequest($websiteId))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function createWebsite(array $payload): Website
    {
        return $this->send(new CreateWebsiteRequest($payload))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function updateWebsite(string $websiteId, array $payload): Website
    {
        return $this->send(new UpdateWebsiteRequest($websiteId, $payload))->dto();
    }

    public function deleteWebsite(string $websiteId): bool
    {
        $this->send(new DeleteWebsiteRequest($websiteId));

        return true;
    }

    public function resetWebsite(string $websiteId): bool
    {
        return $this->send(new ResetWebsiteRequest($websiteId))->dto();
    }
}
