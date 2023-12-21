<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Cart;

session_start();

class CheckoutController extends Controller
{
    public function show_page_checkout(Request $request)
    {
        $data_cart_id_array = explode(",", $request->data_cart_id);
        $cart = Cart::whereIn('cart_id', $data_cart_id_array)->get();
        return view('user.checkout.show_checkout', [
            'cart' => $cart,
            'data_cart_id' => $request->data_cart_id
        ]);
    }
}
