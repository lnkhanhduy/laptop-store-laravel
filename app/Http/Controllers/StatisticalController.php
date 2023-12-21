<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Statistical;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use DB;
use Session;

session_start();


class StatisticalController extends Controller
{
    use UtilitiesTrait;
    public function show_page_statistical()
    {
        $post_view = Post::orderBy('post_views', 'desc')->take(5)->get();
        $product_view = Product::orderBy('product_views', 'desc')->take(5)->get();
        $product_count = Product::count();
        $post_count = Post::count();
        $order_count = Order::count();
        $user_count = User::count();
        return view('admin.statistical.show_statistical', [
            'post_view' => $post_view,
            'product_view' => $product_view,
            'product_count' => $product_count,
            'post_count' => $post_count,
            'order_count' => $order_count,
            'user_count' => $user_count
        ]);
    }
    public function filter_by_date(Request $request)
    {
        $request->validate(
            [
                'from_date' => 'required',
                'to_date' => 'required',
            ]
        );

        $get_statistical = Statistical::whereBetween('statistical_date', [$request->from_date, $request->to_date])->get();
        $sales = Statistical::whereBetween('statistical_date', [$request->from_date, $request->to_date])->sum(DB::raw('CAST(statistical_sales AS DECIMAL(10, 2))'));
        $profit = Statistical::whereBetween('statistical_date', [$request->from_date, $request->to_date])->sum(DB::raw('CAST(statistical_profit AS DECIMAL(10, 2))'));

        return $this->successResponse([$get_statistical->toArray(), $sales, $profit], 'Lấy dữ liệu thành công!', 200);
    }

    public function filter_by_option(Request $request)
    {
        $to_date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($request->value == 5) {
            $get_statistical = Statistical::all();
            $sales = Statistical::sum(DB::raw('CAST(statistical_sales AS DECIMAL(10, 2))'));
            $profit = Statistical::sum(DB::raw('CAST(statistical_profit AS DECIMAL(10, 2))'));
            return $this->successResponse([$get_statistical->toArray(), $sales, $profit], 'Lấy dữ liệu thành công!', 200);
        }

        switch ($request->value) {
            case 1:
                $from_date = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
                break;
            case 2:
                $from_date = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
                $to_date = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
                break;
            case 3:
                $from_date = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
                break;
            case 4:
                $from_date = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
                break;
            default:
                break;
        }

        $get_statistical = Statistical::whereBetween('statistical_date', [$from_date, $to_date])->get();
        $sales = Statistical::whereBetween('statistical_date', [$from_date, $to_date])->sum(DB::raw('CAST(statistical_sales AS DECIMAL(10, 2))'));
        $profit = Statistical::whereBetween('statistical_date', [$from_date, $to_date])->sum(DB::raw('CAST(statistical_profit AS DECIMAL(10, 2))'));

        return $this->successResponse([$get_statistical->toArray(), $sales, $profit], 'Lấy dữ liệu thành công!', 200);
    }
}
