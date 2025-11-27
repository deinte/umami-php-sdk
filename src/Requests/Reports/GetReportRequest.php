<?php

namespace Deinte\UmamiSdk\Requests\Reports;

use Deinte\UmamiSdk\Dto\Report;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetReportRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $reportId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/reports/{$this->reportId}";
    }

    public function createDtoFromResponse(Response $response): Report
    {
        return Report::fromResponse($response->json());
    }
}
