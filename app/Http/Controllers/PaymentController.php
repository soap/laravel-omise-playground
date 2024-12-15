<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Soap\LaravelOmise\Omise;
use Soap\LaravelOmise\Omise\Charge;
use Soap\LaravelOmise\Omise\Error;

class PaymentController extends Controller
{
    public function __construct(protected Charge $chargeApi, protected Omise $omise) {}

    public function create()
    {
        $publicKey = $this->omise->getPublicKey();

        return view('payments.form', compact('publicKey'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required',
            'omiseToken' => 'required_without:omiseSource',
            'omiseSource' => 'required_without:omiseToken',
        ]);

        $paymentData = [
            'amount' => $validated['amount'] * 100,
            'currency' => $validated['currency'],
            'card' => $validated['omiseToken'],
            'return_uri' => route('payment.complete', ['id' => uniqid()]),
        ];

        $response = $this->chargeApi->create($paymentData);
        if ($response instanceof Error) {
            return back()->with('error', $response->getMessage());
        }

        $authorizeUri = $this->chargeApi->authorizeUri();

        $chargeId = $this->chargeApi->id;

        return redirect()->to($authorizeUri);
    }

    public function show($id)
    {
        return view('payments.complete', ['id' => $id]);
    }

    protected function charge($paymentData)
    {
        return $this->chargeApi->create($paymentData);
    }
}
