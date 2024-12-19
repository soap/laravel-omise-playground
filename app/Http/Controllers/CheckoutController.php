<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function handleCheckout(Request $request)
    {
        if (Cart::count() === 0) {
            session()->flash('error', 'Your cart is empty.');

            return redirect()->back();
        }

        $payment_methods = [
            'credit_card' => 'Credit Card',
            'promptpay' => 'QR Prompt Pay',

        ];
        $publicKey = app('omise')->getPublicKey();

        return view('checkout', compact('payment_methods', 'publicKey'));
    }
}
