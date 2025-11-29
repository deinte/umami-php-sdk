<?php

namespace Deinte\UmamiSdk\Requests\Reports;

use Deinte\UmamiSdk\Dto\Report;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateReportRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        protected string $reportId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/reports/{$this->reportId}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Report
    {
        return Report::fromResponse($response->json());
    }
}
