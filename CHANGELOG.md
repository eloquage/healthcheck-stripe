# Changelog

All notable changes to `healthcheck-stripe` will be documented in this file.

## v0.1.7 - 2026-11-03

- Align Composer author and keyword metadata with Eloquage.
- Set the PHPStan analysis script to a 512 MB memory limit.

## v0.1.6 - 2026-11-03

Release the package with Composer identity under the eloquage vendor namespace. This release contains the package metadata and documentation rename; runtime behavior is unchanged.

## 0.1.5 - 2026-10-23

- Support Laravel 12 and 13 on PHP 8.3+.
- Add package configuration fallback for `STRIPE_SECRET`.
- Bound the Stripe SDK dependency to stable supported major versions.
- Add package banner and clear setup and usage examples.
