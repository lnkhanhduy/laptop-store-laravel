<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Statistical;
use App\Models\Voucher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Session;

session_start();
class OrderController extends Controller
{
    use UtilitiesTrait;
    public function show_page_order()
    {
        return view('admin.order.all_order');
    }

    public function show_page_order_detail($order_id)
    {
        $order = Order::where('order_id', $order_id)->with('getOrderDetail', 'getProduct')->first();

        return view('admin.order.order_detail', [
            'order' => $order
        ]);
    }


    public function get_all_order(Request $request)
    {
        try {
            $all_order = Order::orderBy('order_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_order, 'Lấy tất cả đơn hàng thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả đơn hàng ' . $e->getMessage(), 500);
        }
    }

    public function get_all_order_by_status($status)
    {
        if ($status != 2 && $status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_order = Order::where('order_status', $status)->orderBy('order_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_order, 'Lấy đơn hàng thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy đơn hàng ' . $e->getMessage(), 500);
        }
    }

    public function search_order($keyword)
    {
        try {
            $all_order = Order::where('order_name', 'like', '%' . $keyword . '%')->orWhere('order_email', 'like', '%' . $keyword . '%')->orWhere('order_phone', 'like', '%' . $keyword . '%')->orWhere('order_code', 'like', '%' . $keyword . '%')->orderBy('order_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_order, 'Danh sách đơn hàng được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm đơn hàng ' . $e->getMessage(), 500);
        }
    }

    public function change_status_order(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:tbl_order,order_id',
            'order_status' => 'required|in:1,2',
        ]);

        try {
            $order = Order::find($request->order_id);
            $order->order_status = $request->order_status;
            $order->save();
            return $this->successResponse($order, 'Thay đổi trạng thái đơn hàng thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thay đổi trạng thái đơn hàng ' . $e->getMessage(), 500);
        }
    }

    public function save_order_user(Request $request)
    {
        $order = new Order();
        $order->user_id = Session::get('user_id');
        $order->order_code = 'DH' . Str::random(10);
        $order->order_name = $request->order_name;
        $order->order_address = $request->order_address;
        $order->order_phone = $request->order_phone;
        $order->order_note = $request->order_note || '';
        $order->order_payment_method = $request->order_payment;
        $order->voucher_id = $request->voucher_id || 0;
        $order->order_total = $request->order_total;
        $order->order_status = 0;
        $order->save();

        $cart = Cart::where('user_id', Session::get('user_id'))->get();

        foreach ($cart as $key => $value) {
            $product = Product::find($value->product_id);
            if ($product->product_quantity - $product->product_sold >= $value->quantity) {
                $product->product_sold = $product->product_sold + $value->quantity;
                $product->save();

                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->order_id;
                $order_detail->product_id = $value->product_id;
                $order_detail->product_quantity = $value->quantity;
                $order_detail->product_price = $value->getProduct->product_price_discount > 0 ? $value->getProduct->product_price_discount : $value->getProduct->product_price;
                $order_detail->save();
            }

            $time_now = Carbon::now()->toDateString();
            $statistical = Statistical::where('statistical_date', $time_now)->first();

            if ($statistical) {
                $statistical->statistical_quantity = $statistical->statistical_quantity + $value->quantity;
                $statistical->statistical_sales = floatval($statistical->statistical_sales) + floatval($value->getProduct->product_price_discount > 0 ? $value->getProduct->product_price_discount : $value->getProduct->product_price) * $value->quantity;
                $statistical->statistical_profit = floatval($statistical->statistical_profit) + floatval($value->getProduct->product_price_discount > 0 ? $value->getProduct->product_price_discount : $value->getProduct->product_price) * $value->quantity - floatval($value->getProduct->product_cost) * $value->quantity;
                $statistical->save();
            } else {
                $statistical = new Statistical();
                $statistical->statistical_date = $time_now;
                $statistical->statistical_quantity = $value->quantity;
                $statistical->statistical_sales = floatval($value->getProduct->product_price_discount > 0 ? $value->getProduct->product_price_discount : $value->getProduct->product_price) * $value->quantity;
                $statistical->statistical_profit = floatval($value->getProduct->product_price_discount > 0 ? $value->getProduct->product_price_discount : $value->getProduct->product_price) * $value->quantity - floatval($value->getProduct->product_cost) * $value->quantity;
                $statistical->statistical_total_order = 0;
                $statistical->save();
            }
        }

        $statistical->statistical_total_order = $statistical->statistical_total_order + 1;
        $statistical->save();

        if ($request->voucher_id && $request->voucher_id != 0) {
            $voucher = Voucher::find($request->voucher_id);
            if ($voucher) {
                $voucher->voucher_used = $voucher->voucher_used + 1;
                if ($voucher->voucher_quantity == $voucher->voucher_used) {
                    $voucher->voucher_status = 2;
                }

                $voucher->voucher_used_by_user = $voucher->voucher_used_by_user . ',' . Session::get('user_id');
                $voucher->save();
            }
        }
        Cart::where('user_id', Session::get('user_id'))->delete();

        Session::put('message', 'Đặt hàng thành công');
        return Redirect::to('/trang-chu');
    }

    public function show_page_history_order()
    {
        $order = Order::where('user_id', Session::get('user_id'))->with(('getOrderDetail'))->orderBy('order_id', 'desc')->get();

        return view('user.order.show_history_order', compact('order'));
    }
}