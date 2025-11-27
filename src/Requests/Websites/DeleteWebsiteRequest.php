<?php

namespace Deinte\UmamiSdk\Requests\Websites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteWebsiteRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $websiteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/websites/{$this->websiteId}";
    }
}
