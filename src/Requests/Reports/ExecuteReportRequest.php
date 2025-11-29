<?php

namespace Deinte\UmamiSdk\Requests\Reports;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ExecuteReportRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        protected string $endpoint,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/reports/{$this->endpoint}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): array
    {
        return $response->json();
    }
}
