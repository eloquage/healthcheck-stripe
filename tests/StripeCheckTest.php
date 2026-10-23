<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckStripe\StripeConnectivityCheck;
use Mockery\MockInterface;
use Spatie\Health\Enums\Status;

it('fails when stripe secret is missing', function () {
    config()->set('cashier.secret', '');

    $result = StripeConnectivityCheck::new()->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('Missing key');
});

it('succeeds when stripe api returns balance', function () {
    config()->set('cashier.secret', 'sk_test_123');

    /** @var StripeConnectivityCheck&MockInterface $check */
    $check = Mockery::mock(StripeConnectivityCheck::class)->makePartial();
    $check->shouldAllowMockingProtectedMethods();
    $check->shouldReceive('fetchBalance')->once()->andReturn((object) [
        'livemode' => false,
        'object' => 'balance',
        'available' => [
            (object) ['currency' => 'usd', 'amount' => 1000],
        ],
    ]);

    $result = $check->run();

    expect($result->status)->toEqual(Status::ok())
        ->and($result->shortSummary)->toBe('Connected')
        ->and($result->meta['currency'])->toBe('usd');
});

it('fails when stripe api throws exception', function () {
    config()->set('cashier.secret', 'sk_test_123');

    /** @var StripeConnectivityCheck&MockInterface $check */
    $check = Mockery::mock(StripeConnectivityCheck::class)->makePartial();
    $check->shouldAllowMockingProtectedMethods();
    $check->shouldReceive('fetchBalance')->once()->andThrow(new Exception('Invalid API key'));

    $result = $check->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('API error')
        ->and($result->notificationMessage)->toContain('Invalid API key');
});
