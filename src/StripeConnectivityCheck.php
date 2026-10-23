<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckStripe;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use Stripe\StripeClient;
use Throwable;

class StripeConnectivityCheck extends Check
{
    public function run(): Result
    {
        $configuredSecret = config('cashier.secret');

        if (! is_string($configuredSecret) || $configuredSecret === '') {
            $configuredSecret = config('healthcheck-stripe.secret');
        }

        $secret = is_string($configuredSecret) ? $configuredSecret : '';

        if ($secret === '') {
            return Result::make()
                ->failed(__('healthcheck-stripe::messages.missing_key'))
                ->shortSummary('Missing key');
        }

        $started = microtime(true);

        try {
            $balance = $this->fetchBalance($secret);
        } catch (Throwable $exception) {
            return Result::make()
                ->failed(__('healthcheck-stripe::messages.api_error', ['message' => $exception->getMessage()]))
                ->shortSummary('API error');
        }

        $latencyMs = (int) round((microtime(true) - $started) * 1000);

        $meta = [
            'response_time_ms' => $latencyMs,
            'livemode' => $balance->livemode ?? null,
            'object' => $balance->object ?? 'balance',
        ];

        $available = $balance->available ?? null;
        if (is_array($available) && isset($available[0]) && is_object($available[0])) {
            $meta['currency'] = $available[0]->currency ?? null;
        }

        $result = Result::make()
            ->ok(__('healthcheck-stripe::messages.connected'))
            ->shortSummary('Connected')
            ->meta($meta);

        if ($latencyMs > 1500) {
            return $result->warning(__('healthcheck-stripe::messages.slow_response', ['response_time_ms' => $latencyMs]));
        }

        return $result;
    }

    protected function fetchBalance(string $secret): object
    {
        return (new StripeClient($secret))->balance->retrieve();
    }
}
