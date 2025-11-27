# Umami PHP SDK – Progress & Plan

## Context
- Goal: deliver a Saloon-powered PHP SDK for the Umami Analytics API (see `WAY_OF_WORKING.md` for structure guidance).
- Target PHP version: ^8.2.
- Auth modes: bearer token for self-hosted, `x-umami-api-key` for Umami Cloud.
- API reference lives in [`/tmp/umami-docs/content/docs/api`](https://github.com/umami-software/docs/tree/master/content/docs/api) (admin, events, links, me, pixels, websites, website-stats, realtime, reports, sessions, teams, users, etc.).
- Reference implementation: [`ohdearapp/ohdear-php-sdk`](https://github.com/ohdearapp/ohdear-php-sdk) for structure, naming, and tooling conventions.

## Current Status
- Composer metadata updated (package `deinte/umami-php-sdk`, Saloon + pagination + QA tooling).
- Removed Laravel package skeleton directories (`config`, `database`, …) and scaffolded SDK folders (`src/{Concerns,Dto,…}`, `tests/{Fixtures/Saloon,UmamiTests,…}`, `scripts/`).
- Exceptions namespace started with `UmamiException` and `ValidationException`.
- Core connector (`src/Umami.php`) now handles API-key or bearer auth, pagination, defaults, and exception mapping.
- DTO coverage spans authentication, admin/users/teams/websites, sessions/events, website stats, reports, realtime, links, pixels, and sending stats.
- All documented endpoint groups now expose typed concerns, request classes, fixtures, and Pest feature tests (mocked).
- Composer install currently blocked by the sandbox (cannot reach `repo.packagist.org`); revisit once network access is available locally before running QA commands.

## Implementation Plan
1. **Tooling & DX**
   - Install dependencies (`composer install` once allowed) and commit `composer.lock`.
   - Set up Pest config (`tests/Pest.php`), architecture tests, Pint config, and scripts mirroring Oh Dear SDK.
   - Configure PHPStan (level 5 + baseline), Dotenv helper, and QA scripts (`analyse`, `test`, `format`, `baseline`, `real`).

2. **Core SDK Foundation**
   - Implement `src/Umami.php` connector: token/api-key auth, base URL (`https://api.umami.is/v1` default), timeout, headers, pagination, custom exception mapping.
   - Add helper utilities (date conversions, pagination arrays) if needed.
   - Flesh out exception hierarchy and shared DTO helpers.

3. **Domain Modeling & Concerns**
   - Continue adding DTOs/enums for the remaining API domains (reports, stats, sessions, events, realtime, links, admin summaries, etc.).
   - For every endpoint group, add Saloon Request classes (`src/Requests/<Domain>`) and matching concern traits (`src/Concerns/Supports*Endpoints.php`) exposing public methods.
   - Ensure pagination requests implement Saloon’s `Paginatable` interface and return DTO collections.

4. **Fixtures & Tests**
   - Add HTTP fixtures in `tests/Fixtures/Saloon/<domain>/<name>.json` based on docs samples.
   - Write Pest tests per concern under `tests/UmamiTests/`, using Saloon `MockClient` to assert DTO hydration and request wiring.
   - Provide architecture test parity (`tests/ArchTest.php`) and real API smoke script under `tests/TestSupport/scripts/real-test.php`.

5. **Docs & Polish**
   - Update `README.md` with installation, usage examples, auth instructions, and QA commands.
   - Add CHANGELOG entry for initial release.
   - Keep this `PROGRESS.md` updated with endpoint coverage/blockers.
   - Run `composer format`, `composer analyse`, and `composer test` before handoff.

## Coverage Checklist (to be filled as work progresses)
- [x] Authentication (`/auth/login`, `/auth/verify`).
- [x] Me (`/me`, `/me/teams`, `/me/websites`).
- [x] Admin (`/admin/users`, `/admin/websites`, `/admin/teams`).
- [x] Users CRUD + usage/websites.
- [x] Teams CRUD + membership + websites.
- [x] Websites CRUD + reset.
- [x] Website stats (active, metrics, pageviews, stats, series).
- [x] Sessions (list, stats, weekly, detail, properties, data).
- [x] Events & Event Data.
- [x] Reports (CRUD + attribution/breakdown/funnel/goals/journey/retention/revenue/utm).
- [x] Realtime endpoints.
- [x] Links (share links, referral links).
- [x] Pixels (tracking pixels configuration).
- [x] Sending stats (custom event ingestion, etc.).
- [ ] Cloud-specific endpoints (API key management if exposed).
