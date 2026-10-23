# illuma-law/healthcheck-stripe

Checks Stripe API connectivity by retrieving the account balance and measuring response time.

## Usage

```php
use IllumaLaw\HealthCheckStripe\StripeConnectivityCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    StripeConnectivityCheck::new(),
]);
```

## Configuration

Publish config: `php artisan vendor:publish --tag="healthcheck-stripe-config"`

Configure `cashier.secret` or publish the package config with `STRIPE_SECRET`.
Stripe requests taking longer than 1500 ms produce a warning.
