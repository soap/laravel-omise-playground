<?php

namespace App\Contracts;

interface PaymentProcessorInterface
{
    public function createPayment(float $amounnt, string $currency = 'THB', array $paymentDetails = []): array;

    public function processPayment(array $paymentData): array;

    public function refundPayment(string $chargeId, float $amount): bool;

    public function hasRefundSupport(): bool;

    public function isOffline(): bool;
}
