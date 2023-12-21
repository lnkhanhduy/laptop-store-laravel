<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class BrandController extends Controller
{
    use UtilitiesTrait;
    public function show_page_brand()
    {
        return view('admin.brand.all_brand');
    }

    public function get_all_brand(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_brand = Brand::orderBy('brand_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_brand = Brand::orderBy('brand_id', 'desc')->get();
            }

            return $this->successResponse($all_brand, 'Lấy tất cả thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả thương hiệu ' . $e->getMessage(), 500);
        }
    }

    public function get_all_brand_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_brand = Brand::where('brand_status', $status)->orderBy('brand_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_brand, 'Lấy thương hiệu đang ' . $status == 1 ? 'hiển thị' : 'ẩn' . ' thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thương hiệu đang ' . $status == 1 ? 'hiển thị' : 'ẩn' . ' hiển thị ' . $e->getMessage(), 500);
        }
    }

    public function get_brand_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $brand = Brand::where('brand_id', $id)->first();
            if ($brand) {
                return $this->successResponse($brand, 'Lấy thông tin thương hiệu thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy thương hiệu!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin thương hiệu thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_brand($keyword)
    {
        try {
            $all_brand = Brand::where('brand_name', 'like', '%' . $keyword . '%')->orWhere('brand_slug', 'like', '%' . $keyword . '%')->orderBy('brand_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_brand, 'Danh sách thương hiệu tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm thương hiệu ' . $e->getMessage(), 500);
        }
    }

    public function add_brand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
            'brand_slug' => 'required|unique:tbl_brand,brand_slug',
            'brand_status' => 'required|in:0,1',
        ], [
            'brand_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $brand = Brand::create($request->all());
            return $this->successResponse($brand, 'Thêm thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm thương hiệu ' . $e->getMessage(), 500);
        }
    }

    public function edit_brand(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:tbl_brand,brand_id',
            'brand_name' => 'required',
            'brand_slug' => 'required|unique:tbl_brand,brand_slug,' . $request->brand_id . ',brand_id',
            'brand_status' => 'required|in:0,1',
        ], [
            'brand_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $brand = Brand::where('brand_id', $request->brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => $request->brand_slug,
                'brand_status' => $request->brand_status,
            ]);

            return $this->successResponse($brand, 'Cập nhật thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật thương hiệu ' . $e->getMessage(), 500);
        }
    }

    public function delete_brand(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:tbl_brand,brand_id',
        ]);

        try {
            $deleted = Brand::destroy($request->brand_id);
            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy thương hiệu!', 404);
            }

            return $this->successResponse(null, 'Xóa thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa thương hiệu ' . $e->getMessage(), 500);
        }
    }

    public function active_brand($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return $this->errorResponse('Không tìm thấy thương hiệu!', 404);
            }

            $brand->update([
                'brand_status' => 1,
            ]);
            return $this->successResponse($brand, 'Hiển thị thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị thương hiệu thành công ' . $e->getMessage(), 500);
        }
    }

    public function unactive_brand($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return $this->errorResponse('Không tìm thấy thương hiệu!', 404);
            }

            $brand->update([
                'brand_status' => 0,
            ]);
            return $this->successResponse($brand, 'Ẩn thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn thương hiệu thành công ' . $e->getMessage(), 500);
        }
    }

    public function load_brand_user()
    {
        try {
            $brand = Brand::where('brand_status', 1)->get();
            return $this->successResponse($brand, 'Ẩn thương hiệu thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn thương hiệu thành công ' . $e->getMessage(), 500);
        }
    }

    public function get_product_by_brand_user(Request $request)
    {
        $order_by = $request->order_by;

        if($order_by == 'sold') {
            $product = Product::where('product_status', 1)->where('brand_id', $request->brand_id)->orderBy('product_sold', 'desc')->paginate($this->linePerPageUser);
        } elseif($order_by == 'new') {
            $product = Product::where('product_status', 1)->where('brand_id', $request->brand_id)->orderBy('product_id', 'desc')->paginate($this->linePerPageUser);
        } else {
            $product = Product::where('product_status', 1)->where('brand_id', $request->brand_id)
            ->orderByRaw('IF(CAST(product_price_discount AS SIGNED) != 0, CAST(product_price_discount AS SIGNED), CAST(product_price AS SIGNED)) ' . $order_by)
            ->paginate($this->linePerPageUser);
        }

        return $this->successResponse($product, 'Lấy tất cả sản phẩm thành công!', 200);
    }

    public function show_page_brand_user($brand_slug)
    {
        $brand = Brand::where('brand_slug', $brand_slug)->first();
        return view('user.product.show_product_by_brand', compact('brand'));
    }
}
