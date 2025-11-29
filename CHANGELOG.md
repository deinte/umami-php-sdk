# Changelog

All notable changes to `deinte/umami-php-sdk` will be documented in this file.

## [0.0.1] - 2025-11-29

**Full Changelog**: https://github.com/deinte/umami-php-sdk/commits/v0.0.1

### Added

- Initial release of the Umami PHP SDK
  
- Typed Saloon connector for the Umami Analytics API
  
- Support for both Umami Cloud (API key) and self-hosted (bearer token) authentication
  
- Complete API coverage for all documented endpoints:
  
  - Authentication (`/auth/login`, `/auth/verify`)
  - Me endpoints (`/me`, `/me/teams`, `/me/websites`)
  - Admin endpoints (`/admin/users`, `/admin/websites`, `/admin/teams`)
  - Users CRUD operations + usage/websites
  - Teams CRUD operations + membership + websites
  - Websites CRUD operations + reset
  - Website stats (active visitors, metrics, pageviews, stats, series)
  - Sessions (list, stats, weekly, detail, properties, data)
  - Events & Event Data
  - Reports (CRUD + attribution/breakdown/funnel/goals/journey/retention/revenue/utm)
  - Realtime endpoints
  - Links (share links, referral links)
  - Pixels (tracking pixels configuration)
  - Sending stats (custom event ingestion)
  
- Full DTO coverage with type safety for all API responses
  
- Pagination support using Saloon's pagination plugin
  
- Comprehensive test suite with fixtures and mocked HTTP responses
  
- PHPStan level 5 static analysis
  
- Laravel Pint code formatting
  
- Documentation and usage examples in README
  

### Development

- PHP 8.2+ requirement
- Saloon 3.14+ for HTTP client
- Pest for testing
- Architecture tests to ensure code quality
- Real API smoke test script for manual verification
