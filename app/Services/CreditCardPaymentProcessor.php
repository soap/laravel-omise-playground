<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use Soap\LaravelOmise\Omise\Error;

class CreditCardPaymentProcessor implements PaymentProcessorInterface
{
    /**
     * Use token to authorize payment
     */
    public function createPayment(float $amounnt, string $currency = 'THB', array $paymentDetails = []): array
    {
        $charge = app('omise')->charge()->create([
            'amount' => $amounnt * 100,
            'currency' => $currency,
            'card' => $paymentDetails['token'],
            'capture' => $paymentDetails['capture'] ?? true,
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
        ];
    }

    /**
     * Process payment using charge id
     */
    public function processPayment(array $paymentData): array 
    {
        return [];
    }

    /**
     * Refund payment using charge id
     */
    public function refundPayment(string $chargeId, float $amount): bool 
    {
        return true;
    }

    public function hasRefundSupport(): bool
    {
        return true;
    }

    public function isOffline(): bool
    {
        return false;
    }
}
