<?php

namespace App\Factories;

use App\Contracts\PaymentProcessorFactoryInterface;
use App\Contracts\PaymentProcessorInterface;
use App\Services\CreditCardPaymentProcessor;
use App\Services\PromptPayPaymentProcessor;

class PaymentProcessorFactory implements PaymentProcessorFactoryInterface
{
    public function make(string $paymentMethod): PaymentProcessorInterface
    {
        switch ($paymentMethod) {
            case 'credit_card':
                return new CreditCardPaymentProcessor;
            case 'promptpay':
                return new PromptPayPaymentProcessor;
            default:
                throw new \InvalidArgumentException('Invalid payment method');
        }
    }
}
