<?php

namespace App\Http\Controllers;

use App\Factories\PaymentProcessorFactory;
use Illuminate\Http\Request;
use Soap\LaravelOmise\Omise;
use Soap\LaravelOmise\Omise\Error;

class PaymentController extends Controller
{
    public function __construct(protected PaymentProcessorFactory $paymentProcessorFactory, protected Omise $omise) {}

    public function handlePaymentMethod(Request $request)
    {
        $payment_method = $request->payment_method;
        $amount = $request->amount;
        $paymentProcessor = $this->paymentProcessorFactory->make($payment_method);
        $result = $paymentProcessor->createPayment($amount, 'THB', [
            'return_uri' => route('payment.complete', ['id' => uniqid()]),
            'capture' => true,
            'token' => $request->omiseToken ?? null,
        ]);

        if ($paymentProcessor->isOffline()) {
            // wait for payment confirmation
            return view('payments.pending', compact('payment_method', 'amount', 'result'));
        }

        return view('payments.complete', compact('payment_method', 'amount', 'result'));
    }

    public function show($id)
    {
        return view('payments.complete', ['id' => $id]);
    }
}
