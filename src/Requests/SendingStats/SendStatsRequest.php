<?php

namespace Deinte\UmamiSdk\Requests\SendingStats;

use Deinte\UmamiSdk\Dto\SendResult;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class SendStatsRequest extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::POST;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/send';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): SendResult
    {
        return SendResult::fromResponse($response->json());
    }
}
