<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::content();
        return view('cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->quantity,
            'weight' => $request->weight,
            'options' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is added to cart Successfully !');

        return redirect()->back();
    }

    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'rowId' => 'required',
            'qty' => 'required|numeric|gt:0'
        ]);
        \Cart::update($validated['rowId'], $validated['qty']);

        session()->flash('success', 'Item is updated successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->rowId);
        session()->flash('success', 'Item removed from cart successfully !');

        return redirect()->back();
    }

    public function clearAllCart()
    {
        \Cart::destroy();

        session()->flash('success', 'All items in cart cleared successfully !');

        return redirect()->route('cart.list');
    }
}
