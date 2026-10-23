# Healthcheck stripe for Laravel

[![Tests](https://github.com/eloquage/healthcheck-stripe/actions/workflows/run-tests.yml/badge.svg)](https://github.com/eloquage/healthcheck-stripe/actions)
[![Packagist License](https://img.shields.io/badge/Licence-MIT-blue)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://img.shields.io/packagist/v/illuma-law/healthcheck-stripe?label=Version)](https://packagist.org/packages/illuma-law/healthcheck-stripe)

A focused stripe health check for Spatie's [Laravel Health](https://spatie.be/docs/laravel-health/v1/introduction) package.

This package provides a simple, direct health check to verify that your Stripe API credentials are valid and that the Stripe API is reachable.

## Features

- **Connectivity Check:** Verifies that your Laravel application can successfully connect to Stripe's API.
- **Latency Monitoring:** Measures the response time of the Stripe API. If it exceeds a threshold (1500ms), the check will degrade to a Warning state.
- **Credential Validation:** Ensures that your `CASHIER_SECRET` or `STRIPE_SECRET` is correctly configured and accepted by Stripe.

## Installation

Require this package with composer:

```shell
composer require illuma-law/healthcheck-stripe
```

## Usage & Integration

Register the check inside your application's health service provider (e.g. `AppServiceProvider` or a dedicated `HealthServiceProvider`), alongside your other Spatie Laravel Health checks:

### Basic Registration

```php
use IllumaLaw\HealthCheckStripe\StripeConnectivityCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    StripeConnectivityCheck::new(),
]);
```

### Expected Result States

The check interacts with the Spatie Health dashboard and JSON endpoints using these states:

- **Ok:** Stripe API credentials are valid and the service is responsive.
- **Warning:** Stripe responded successfully, but the response time was higher than 1500ms.
- **Failed:** Stripe was unreachable, the secret key is missing, or the API returned an authentication error.

## Testing

Run the test suite:

```shell
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
