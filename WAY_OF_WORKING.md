# SDK Way of Working

This document captures the conventions that shape the `ohdear-php-sdk`. Treat it as a blueprint for future SDKs so that new client libraries feel and operate the same way.

## Goals & Principles
- Provide a thin, typed wrapper around the Oh Dear API powered by [Saloon](https://docs.saloon.dev/).
- Keep the public surface expressive (DTOs, enums, fluent methods) while hiding HTTP details in dedicated request objects.
- Make every capability testable in isolation through deterministic fixtures.
- Enforce consistency with light-weight architecture rules and static analysis.

## Technology Stack
- **Language:** PHP 8.1+
- **HTTP:** `saloonphp/saloon` v3 and `saloonphp/pagination-plugin`
- **Testing:** [Pest](https://pestphp.com/) + Saloon `MockClient`
- **Static analysis:** PHPStan level 5 (+ baseline)
- **Formatting:** [Laravel Pint](https://laravel.com/docs/master/pint)
- **Environment helpers:** `vlucas/phpdotenv` for local and test scripts

Composer scripts wrap the common tasks:

| Command | Purpose |
| --- | --- |
| `composer test` | Run the Pest suite (`vendor/bin/pest -p`). |
| `composer analyse` | Execute PHPStan on `src/`. |
| `composer format` | Run Pint. |
| `composer baseline` | Regenerate the PHPStan baseline. |
| `composer real` | Hit the live API via `tests/TestSupport/scripts/real-test.php` (requires an API token). |

## Repository Layout

| Path | Description |
| --- | --- |
| `src/OhDear.php` | Central Saloon connector that wires auth, base URL, headers, timeout and pagination behaviour. |
| `src/Concerns/` | Traits (`Supports*Endpoints`) that group related endpoints and hide request orchestration. |
| `src/Requests/<Domain>/` | Saloon Request classes per API action (`GetMonitorsRequest`, `CreateMonitorRequest`, ...). |
| `src/Dto/` | Immutable data-transfer objects with `fromResponse`/`collect` helpers. |
| `src/Enums/` | PHP enums for constrained values (check types, cron types, uptime splits, ...). |
| `src/Exceptions/` | Domain-specific exceptions (`OhDearException`, `ValidationException`). |
| `src/Helpers/Helpers.php` | Cross-cutting helpers (currently date format conversion). |
| `tests/OhDearTests/` | Feature tests per concern (one Pest file per domain). |
| `tests/Fixtures/Saloon/` | JSON fixtures consumed by `MockResponse::fixture()`. |
| `tests/ArchTest.php` | Architecture tests that guard naming and inheritance rules. |
| `tests/Pest.php` | Global Pest config plus the `ohDearMock()` factory and helpers. |
| `scripts/` & `tests/TestSupport/scripts/` | Utility scripts (e.g. `real-test.php`) for manual/live verification. |

## HTTP Layer Design

### Base Connector
- `OhDear` extends `Saloon\Http\Connector` and implements `HasPagination`.
- Authentication is token-based via `TokenAuthenticator`. Tokens are injected in the constructor alongside an optional base URL and timeout.
- Traits `AcceptsJson` and `AlwaysThrowOnErrors` ensure JSON content negotiation and surface HTTP failures as exceptions.
- `defaultHeaders()` sets `Accept` and `Content-Type` to JSON. `defaultConfig()` pushes the configured timeout.
- `getRequestException()` maps `422` responses to `ValidationException` and everything else to `OhDearException`, preserving the Saloon `Response`.
- Pagination uses a custom anonymous `PagedPaginator` that expects API responses to expose `meta.current_page` and `meta.last_page`. `getPageItems()` delegates to the request’s `createDtoFromResponse`, so paginated requests must implement that method carefully.

### Domain Concerns
- Every group of endpoints lives inside a trait under `src/Concerns/Supports*Endpoints.php`.
- Traits declare a `@mixin \OhDear\PhpSdk\OhDear` docblock to hint to static analysers/IDEs that connector methods are available.
- Each method inside a concern instantiates the dedicated Request class, calls `$this->send($request)` (or `$this->paginate($request)`), and returns DTOs or scalar results. Mutating calls typically return `$this` for fluent chaining.
- Docblocks annotate complex return types (`/** @return iterable<int, Monitor> */`) to keep static analysis accurate.

The current concerns cover:

| Trait | Responsibilities (examples) |
| --- | --- |
| `SupportsMeEndpoint` | Fetch the authenticated user profile. |
| `SupportsMonitorEndpoints` | List, show, create, update, delete monitors; manage notification destinations; fetch check summaries. |
| `SupportsCheckEndpoints` | Enable/disable/snooze/schedule checks and trigger check runs. |
| `SupportsApplicationHealthChecksEndpoints` | Read checks and their history per monitor. |
| `SupportsBrokenLinksEndpoints` | Paginated broken-link reports. |
| `SupportsCertificateHealthEndpoints` | Retrieve certificate health details. |
| `SupportsCronCheckDefinitionsEndpoints` | CRUD + snooze/unsnooze cron check definitions. |
| `SupportsDetectedCertificatesEndpoints` | List or show detected TLS certificates. |
| `SupportsDnsHistoryItemsEndpoints` | DNS change history per monitor. |
| `SupportsDowntimeEndpoints` | Time-bounded downtime history and deletion. |
| `SupportsLighthouseReportsEndpoints` | List LHRs, fetch single or latest report. |
| `SupportsMaintenancePeriodEndpoints` | Create/list/update/delete maintenance windows and start/stop ad-hoc maintenance. |
| `SupportsMixedContentEndpoints` | Retrieve mixed-content scan output. |
| `SupportsSitemapEndpoints` | Fetch sitemap details for a monitor. |
| `SupportsStatusPageEndpoints` | Manage status pages and public updates. |
| `SupportsUptimeEndpoints` | Retrieve uptime aggregates split by hour/day/... . |
| `SupportsUptimeMetricsEndpoints` | Fetch HTTP, Ping, and TCP metric breakdowns. |

When a new API area is added, create one trait per domain, then import it into `OhDear` via `use TraitName;`.

## Request Classes

Each request class encapsulates a single API call and extends `Saloon\Http\Request`.

- **Structure:** declare a `protected Method $method`, accept constructor arguments for identifiers/query/body, and implement `resolveEndpoint()`.
- **Query parameters:** override `defaultQuery()` when filtering/splitting is required. Complex filters follow the API’s bracket notation (e.g. `'filter[start]'`).
- **Bodies:** implement `Saloon\Contracts\Body\HasBody` and pull in `HasJsonBody` to send JSON payloads. Provide `defaultBody()` returning the payload array.
- **DTO creation:** implement `createDtoFromResponse(Response $response)` and return either a single DTO, an array of DTOs, or primitive arrays. For paginated requests return an array/list so `paginate()->items()` can yield typed objects.
- **Pagination contract:** list-style requests also implement `Saloon\PaginationPlugin\Contracts\Paginatable`. The connector handles the actual pagination loop.
- **Consistency:** Request filenames follow `<Action><Resource>Request.php` and live under `src/Requests/<PluralResource>/`.
- **Utilities:** Use `OhDear\PhpSdk\Helpers\Helpers::convertDateFormat()` when the API expects `YmdHis` timestamps (downtime/uptime metrics).

### Sample Template
```php
class GetMonitorsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function __construct(protected ?int $teamId = null) {}

    public function resolveEndpoint(): string
    {
        return '/monitors';
    }

    protected function defaultQuery(): array
    {
        return $this->teamId ? ['filter' => ['team_id' => $this->teamId]] : [];
    }

    /** @return array<int, Monitor> */
    public function createDtoFromResponse(Response $response): array
    {
        return Monitor::collect($response->json('data'));
    }
}
```

## Data Modeling

- DTOs live under `src/Dto/` and expose typed public properties populated through constructor promotion.
- Every DTO provides `fromResponse(array $data): self` to translate API payloads into PHP objects plus `collect(...)` helpers for bulk transformations.
- Some DTOs depend on a `Response` object (when shape differs between success/error). Others accept raw arrays, allowing reuse in nested structures.
- PHP enums (`src/Enums`) wrap finite string values such as `CheckType`, `CronType`, `UptimeSplit`, and `UptimeMetricsSplit`. Always prefer enums over raw strings in new code to prevent typo bugs.
- Arrays with mixed content (e.g. `meta`, `checks`) stay as plain arrays but the DTO constructor defaults to empty arrays to avoid undefined-index issues.

## Error Handling

- `OhDearException` extends `Exception` and stores the originating Saloon `Response`.
- `ValidationException` extends `OhDearException` and parses the `errors` payload, exposing helpers such as `getErrorsForField()` and `getAllErrorMessages()`. It is thrown for any 422 response.
- The connector’s `AlwaysThrowOnErrors` trait ensures that any non-success HTTP status routes through `getRequestException()`.
- Methods can rely on Saloon’s `dto()`/`dtoOrFail()` helpers: `dto()` returns the object returned by `createDtoFromResponse`, while `dtoOrFail()` throws the Saloon exception when the DTO factory fails or when the response is empty.

## Testing Strategy

- **Unit/feature tests:** Each concern has a matching Pest file under `tests/OhDearTests/`. They focus on behaviour (e.g. “can create a monitor”) and assert DTO fields rather than raw arrays.
- **Mocking HTTP:** Tests call `MockClient::global([...])` to map a Request class to `MockResponse::fixture('<name>')`. Fixtures sit in `tests/Fixtures/Saloon/` and mirror real API responses.
- **Test bootstrap:** `tests/Pest.php` defines `ohDearMock()` which loads `.env` values from `tests/TestSupport/.env` (if present) using Dotenv and creates the `OhDear` connector. `markTestComplete()` acts as a stub expectation for void responses.
- **Architecture tests:** `tests/ArchTest.php` protects invariants—requests must extend `Saloon\Http\Request`, concerns must be traits with the `Supports` prefix, enums must live in `OhDear\PhpSdk\Enums`, and debug helpers (`dd`, `dump`, …) are forbidden.
- **Real API smoke test:** `composer real` executes `tests/TestSupport/scripts/real-test.php` which loads live credentials and exercises the SDK against a real account. Use this sparingly.

## Tooling, QA & CI Expectations

- Keep Passable: run `composer test` and `composer analyse` locally before pushing.
- Static analysis is configured in `phpstan.neon` and only scans `src/`. Update the baseline (`composer baseline`) if new intentional violations are introduced, but prefer fixing root causes.
- Formatting uses Pint—run `composer format` to enforce coding standards (PSR-12 compatible). Avoid committing formatting noise unrelated to the change.

## Adding or Changing Endpoints

1. **Model the data:** Create or update DTOs/enums under `src/Dto` or `src/Enums`. Include typed properties and defensive defaults.
2. **Add the request:** Create a new `Request` class inside `src/Requests/<Domain>`. Implement the correct HTTP method, endpoint, query/body, and `createDtoFromResponse()`.
3. **Expose via a concern:** Extend/introduce a `Supports*Endpoints` trait that wires the request into a public method. Annotate return types and keep the implementation a thin pass-through.
4. **Register with the connector:** Import the trait inside `src/OhDear.php`.
5. **Tests & fixtures:** Add/extend fixtures in `tests/Fixtures/Saloon/`. Mirror the API response as closely as possible. Write or update a Pest test under `tests/OhDearTests/` that exercises the new method using `MockClient`.
6. **Docs:** Update `README.md` (and the changelog if needed) to describe the new capability so users can discover it.
7. **Quality gates:** Rerun `composer format`, `composer analyse`, and `composer test`.

## Naming & Coding Conventions

- One class/trait/interface per file, PSR-4 aligned.
- Trait names always start with `Supports` and end with `Endpoints`. Request names end with `Request`.
- Use scalar type hints everywhere, public properties are promoted in constructors for DTOs.
- For arrays returned from API responses, document expected shapes using phpdoc (`/** @return array<int, StatusPage> */`).
- Prefer returning DTOs or dedicated value objects instead of associative arrays, unless the payload is truly dynamic.
- Keep helper functions inside `src/Helpers` rather than scattering global helpers.
- Avoid debug helpers (`dd`, `dump`, `var_dump`, ...)—the architecture test enforces this.

## References & Further Reading

- `README.md` – high-level usage examples and user-facing docs.
- `CHANGELOG.md` – release history.
- [Oh Dear API docs](https://ohdear.app/docs/integrations/the-oh-dear-api) – source of truth for payload shapes and parameters.

Use this document as the reference point when bootstrapping new SDKs so that each library shares the same structure, developer experience, and quality gates.
