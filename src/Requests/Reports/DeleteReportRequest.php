<?php

namespace Deinte\UmamiSdk\Requests\Reports;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DeleteReportRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $reportId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/reports/{$this->reportId}";
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return (bool) $response->json('ok', true);
    }
}
