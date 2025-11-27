<?php

namespace Deinte\UmamiSdk;

use Deinte\UmamiSdk\Concerns\SupportsAdminEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsAuthenticationEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsEventEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsMeEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsWebsiteEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsUserEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsTeamEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsWebsiteStatsEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsSessionEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsReportEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsRealtimeEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsLinkEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsPixelEndpoints;
use Deinte\UmamiSdk\Concerns\SupportsSendingStats;
use Deinte\UmamiSdk\Exceptions\UmamiException;
use Deinte\UmamiSdk\Exceptions\ValidationException;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Throwable;

class Umami extends Connector implements HasPagination
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use SupportsAdminEndpoints;
    use SupportsAuthenticationEndpoints;
    use SupportsEventEndpoints;
    use SupportsMeEndpoints;
    use SupportsWebsiteEndpoints;
    use SupportsUserEndpoints;
    use SupportsTeamEndpoints;
    use SupportsWebsiteStatsEndpoints;
    use SupportsSessionEndpoints;
    use SupportsReportEndpoints;
    use SupportsRealtimeEndpoints;
    use SupportsLinkEndpoints;
    use SupportsPixelEndpoints;
    use SupportsSendingStats;

    public function __construct(
        protected readonly string $token,
        protected readonly string $baseUrl = 'https://api.umami.is/v1',
        protected readonly int $timeoutInSeconds = 10,
        protected readonly bool $useApiKeyHeader = true,
    ) {}

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrl, '/');
    }

    protected function defaultHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->token !== '') {
            $headers[$this->useApiKeyHeader ? 'x-umami-api-key' : 'Authorization'] = $this->useApiKeyHeader
                ? $this->token
                : 'Bearer '.$this->token;
        }

        return $headers;
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => $this->timeoutInSeconds,
        ];
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        if ($response->status() === 422) {
            return new ValidationException($response);
        }

        return new UmamiException(
            $response,
            $senderException?->getMessage() ?? 'Request failed',
            $senderException?->getCode() ?? 0,
        );
    }

    public function paginate(Request $request): Paginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator
        {
            protected function isLastPage(Response $response): bool
            {
                $page = (int) $response->json('page', 1);
                $pageSize = (int) $response->json('pageSize', 0);
                $count = (int) $response->json('count', 0);

                if ($pageSize <= 0) {
                    return true;
                }

                return ($page * $pageSize) >= $count;
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $request->createDtoFromResponse($response);
            }
        };
    }
}
