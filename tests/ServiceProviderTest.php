<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckStripe\HealthcheckStripeServiceProvider;
use Illuminate\Support\ServiceProvider;

it('registers the config publish path under the correct tag', function () {
    $provider = app()->getProvider(IllumaLaw\HealthCheckStripe\HealthcheckStripeServiceProvider::class);
    $source = dirname((new ReflectionClass($provider))->getFileName()).'/../config/healthcheck-stripe.php';

    expect(ServiceProvider::pathsToPublish($provider::class, 'healthcheck-stripe-config'))
        ->toBe([$source => config_path('healthcheck-stripe.php')]);
});
