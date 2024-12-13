<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Soap\LaravelOmise\Omise\Charge;
use Soap\LaravelOmise\OmiseConfig;

class PaymentController extends Controller
{
    public function __construct(protected Charge $chargeApi, protected OmiseConfig $omiseConfig) {}

    public function create()
    {
        $publicKey = $this->omiseConfig->getPublicKey();

        return view('payments.form', compact('publicKey'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required',
            'omiseToken' => 'string',
            'omiseSource' => 'string',
        ]);

        $paymentData = [
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'return_uri' => route('payments.complete'),
        ];

        $this->chargeApi->create($paymentData);

        $authorizeUri = $this->chargeApi->authorizeUri();

        $chargeId = $this->chargeApi->id;

        return redirect()->to($authorizeUri);
    }

    public function show($id)
    {
        return view('payments.complete', ['id' => $id]);
    }
}
