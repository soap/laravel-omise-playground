<?php

namespace App\Contracts;

interface PaymentProcessorFactoryInterface
{
    public function make(string $paymentMethod): PaymentProcessorInterface;
}
