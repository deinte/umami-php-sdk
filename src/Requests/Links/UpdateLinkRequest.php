<?php

namespace Deinte\UmamiSdk\Requests\Links;

use Deinte\UmamiSdk\Dto\Link;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateLinkRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        protected string $linkId,
        protected array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/links/{$this->linkId}";
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Link
    {
        return Link::fromResponse($response->json());
    }
}
