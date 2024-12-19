<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use Soap\LaravelOmise\Omise\Error;

class PromptPayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(float $amounnt, string $currency = 'THB', array $paymentDetails = []): array
    {
        $source = app('omise')->source()->create([
            'type' => 'promptpay',
            'amount' => $amounnt * 100,
            'currency' => $currency,
        ]);

        if ($source instanceof Error) {
            return [
                'code' => $source->getCode(),
                'error' => $source->getMessage(),
            ];
        }

        $charge = app('omise')->charge()->create([
            'amount' => $amounnt * 100,
            'currency' => $currency,
            'source' => $source->id,
        ]);

        if ($charge instanceof Error) {
            return [
                'code' => $charge->getCode(),
                'error' => $charge->getMessage(),
            ];
        }

        return [
            'charge_id' => $charge->id,
            'amount' => $charge->amount / 100,
            'currency' => $charge->currency,
            'status' => $charge->status,
            'qr_image' => $charge->source['scannable_code']['image']['download_uri'],
            'expires_at' => $charge->expires_at,
        ];
    }

    public function processPayment(array $paymentData): array 
    {
        return [];
    }

    public function refundPayment(string $chargeId, float $amount): bool
    {
        return false;
    }

    public function hasRefundSupport(): bool
    {
        return false;
    }

    public function isOffline(): bool
    {
        return true;
    }
}
