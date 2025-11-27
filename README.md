# Umami PHP SDK

Typed Saloon connector for the [Umami Analytics](https://umami.is) API. The SDK mirrors the structure of
[`ohdearapp/ohdear-php-sdk`](https://github.com/ohdearapp/ohdear-php-sdk) so developers get DTOs, enums,
request classes, concerns, fixtures, and tests that feel familiar across SDKs. All documented API
endpoints are wired up—see `PROGRESS.md` for a living checklist and notes.

## Installation

```bash
composer require deinte/umami-php-sdk
```

## Usage

```php
use Deinte\UmamiSdk\Umami;

$umami = new Umami(
    token: getenv('UMAMI_API_TOKEN'),
    baseUrl: getenv('UMAMI_BASE_URL') ?: 'https://api.umami.is/v1',
    timeoutInSeconds: 15,
    useApiKeyHeader: true, // Set to false when using self-hosted bearer tokens.
);

$profile = $umami->me();
```

### Authentication

- **Umami Cloud** – Create an API key in the dashboard and pass it to the constructor with `$useApiKeyHeader = true`
  (default). The SDK will send it as the `x-umami-api-key` header against `https://api.umami.is/v1`.
- **Self-hosted** – Authenticate via `POST /api/auth/login` and pass the resulting bearer token to the constructor
  with `$useApiKeyHeader = false`. Point the base URL to your installation (e.g. `https://example.com/api`).

You can also wire the SDK through `vlucas/phpdotenv` during tests by using the helper defined in `tests/Pest.php`.

## Testing & QA

```bash
composer test     # Pest suite (uses Saloon MockClient fixtures)
composer analyse  # PHPStan level 5
composer format   # Laravel Pint
composer baseline # Regenerate PHPStan baseline
composer real     # Manual smoke test against a live Umami project (requires env vars)
```

## Contributing

1. Fork the repo and install dependencies (`composer install`). If the network is unavailable, copy the vendor
   directory from another machine to keep iterating on the SDK structure.
2. Run `composer format`, `composer analyse`, and `composer test` before opening a PR.
3. Document endpoint coverage in `PROGRESS.md` and describe any limitations or missing fixtures.

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.
