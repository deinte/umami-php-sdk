<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\Link;
use Deinte\UmamiSdk\Dto\PaginatedResult;
use Deinte\UmamiSdk\Requests\Links\DeleteLinkRequest;
use Deinte\UmamiSdk\Requests\Links\GetLinkRequest;
use Deinte\UmamiSdk\Requests\Links\GetLinksRequest;
use Deinte\UmamiSdk\Requests\Links\UpdateLinkRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsLinkEndpoints
{
    public function links(array $query = []): PaginatedResult
    {
        return $this->send(new GetLinksRequest($query))->dto();
    }

    public function link(string $linkId): Link
    {
        return $this->send(new GetLinkRequest($linkId))->dto();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function updateLink(string $linkId, array $payload): Link
    {
        return $this->send(new UpdateLinkRequest($linkId, $payload))->dto();
    }

    public function deleteLink(string $linkId): bool
    {
        return $this->send(new DeleteLinkRequest($linkId))->dto();
    }
}
