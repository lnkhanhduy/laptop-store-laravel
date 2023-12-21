<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Session;

session_start();
class CartController extends Controller
{
    use UtilitiesTrait;
    public function show_page_cart_user()
    {
        return view('user.cart.show_cart');
    }

    public function get_cart_user()
    {
        try {
            $cart = Cart::where('user_id', Session::get('user_id'))->with('getProduct')->get();
            return $this->successResponse($cart, 'Lấy giỏ hàng thành công!', 200);
        } catch(\Exception $e) {
            return $this->errorResponse('Lấy giỏ hàng thất bại! ' . $e->getMessage(), 500);
        }
    }

    public function add_cart_user(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'product_id' => 'required|exists:tbl_product,product_id',
        ]);

        try {
            $product = Product::find($request->product_id);
            if($product->product_sold >= $product->product_quantity
            || $product->product_quantity < $request->quantity) {
                return $this->errorResponse('Số lượng trong kho không đủ!', 404);
            }

            $cart = Cart::where('product_id', $request->product_id)->where('user_id', Session::get('user_id'))->first();
            if($cart) {
                $cart->quantity = $cart->quantity + $request->quantity;
                $cart->save();
            } else {
                $cart = new Cart();
                $cart->user_id = Session::get('user_id');
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->save();
            }

            return $this->successResponse($cart, 'Thêm vào giỏ hàng thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm vào giỏ hàng ' . $e->getMessage(), 500);
        }
    }

    public function update_cart_user(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'cart_id' => 'required|exists:tbl_cart,cart_id'
        ]);

        try {
            $cart = Cart::find($request->cart_id);

            $product = Product::find($cart->product_id);
            if($product->product_sold >= $product->product_quantity
            || $product->product_quantity < $request->quantity) {
                return $this->errorResponse('Số lượng trong kho không đủ!', 422);
            }

            $cart->quantity = $request->quantity;
            $cart->save();

            return $this->successResponse($cart, 'Cập nhật giỏ hàng thành công!', 200);
        } catch(\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật giỏ hàng ' . $e->getMessage(), 500);
        }
    }

    public function delete_cart_user(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:tbl_cart,cart_id'
        ]);

        try {
            $deleted = Cart::destroy($request->cart_id);
            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy giỏ hàng!', 404);
            }

            return $this->successResponse($deleted, 'Xóa giỏ hàng thành công!', 200);
        } catch(\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa giỏ hàng ' . $e->getMessage(), 500);
        }
    }
}
