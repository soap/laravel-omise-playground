<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Soap\Treasurer\Omise\Charge;
use Soap\Treasurer\Treasurer;

class PaymentController extends Controller
{
    public function __construct(protected Charge $chargeApi, protected Treasurer $treasurer) {}

    public function create()
    {
        $publicKey = $this->treasurer->getPublicKey();

        return view('payments.form', compact('publicKey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required',
            'omiseToken' => 'string',
            'omiseSource' => 'string',
        ]);

        $paymentData = [
            'amount' => $request->amount,
            'currency' => $request->currency,
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
