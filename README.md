# Healthcheck Stripe

[![Tests](https://github.com/eloquage/healthcheck-stripe/actions/workflows/run-tests.yml/badge.svg)](https://github.com/eloquage/healthcheck-stripe/actions)
[![Latest Version](https://img.shields.io/packagist/v/illuma-law/healthcheck-stripe)](https://packagist.org/packages/illuma-law/healthcheck-stripe)
[![License](https://img.shields.io/packagist/l/illuma-law/healthcheck-stripe)](LICENSE.md)

![Stripe connectivity health check illustration](art/banner.png)

A Laravel Health check that calls Stripe's Balance API to verify that your credentials and API connection work.

## Requirements

- PHP 8.3 or later
- Laravel 12 or 13
- [Spatie Laravel Health](https://spatie.be/docs/laravel-health)
- A Stripe secret key

## Install

```bash
composer require illuma-law/healthcheck-stripe
```

## Configure

Set either `CASHIER_SECRET` when using Laravel Cashier or `STRIPE_SECRET` for this package's own configuration:

```dotenv
STRIPE_SECRET=sk_test_...
```

The check uses `cashier.secret` first and falls back to `healthcheck-stripe.secret`.

## Use

Register the check with your Laravel Health checks:

```php
use IllumaLaw\HealthCheckStripe\StripeConnectivityCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    StripeConnectivityCheck::new(),
]);
```

The check retrieves the account balance. Missing credentials or a Stripe API error produce a failed result. A successful response taking longer than 1500 ms produces a warning; faster responses are healthy.

## Tests

```bash
composer install
composer test
composer analyse
```

## License

MIT. See [LICENSE.md](LICENSE.md).
