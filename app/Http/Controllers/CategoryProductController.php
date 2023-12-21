<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();


class CategoryProductController extends Controller
{
    use UtilitiesTrait;

    public function show_page_category_product()
    {
        return view('admin.category_product.all_category_product');
    }

    public function get_all_category_product(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_category_product = CategoryProduct::orderBy('category_product_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_category_product = CategoryProduct::orderBy('category_product_id', 'desc')->get();
            }

            foreach ($all_category_product as $key => $value) {
                $value->parent_name = $value->getNameCategory->category_product_name ?? 'Danh mục cha';
            }
            return $this->successResponse($all_category_product, 'Lấy tất cả danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả danh mục ' . $e->getMessage(), 500);
        }
    }

    public function get_all_category_product_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_category_product = CategoryProduct::where('category_product_status', $status)->orderBy('category_product_id', 'desc')->paginate($this->linePerPageAdmin);
            foreach ($all_category_product as $key => $value) {
                $value->parent_name = $value->getNameCategory->category_product_name ?? 'Danh mục cha';
            }
            return $this->successResponse($all_category_product, 'Lấy danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy danh mục ' . $e->getMessage(), 500);
        }
    }

    public function get_category_product_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $category_product = CategoryProduct::where('category_product_id', $id)->first();
            if ($category_product) {
                return $this->successResponse($category_product, 'Lấy thông tin danh mục thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy danh mục!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin danh mục thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_category_product($keyword)
    {
        try {
            $all_category_product = CategoryProduct::where('category_product_name', 'like', '%' . $keyword . '%')->orWhere('category_product_slug', 'like', '%' . $keyword . '%')->orderBy('category_product_id', 'desc')->paginate($this->linePerPageAdmin);
            foreach ($all_category_product as $key => $value) {
                $value->parent_name = $value->getNameCategory->category_product_name ?? 'Danh mục cha';
            }
            return $this->successResponse($all_category_product, 'Danh sách danh mục được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm danh mục ' . $e->getMessage(), 500);
        }
    }

    public function add_category_product(Request $request)
    {
        $request->validate([
            'category_product_name' => 'required',
            'category_product_slug' => 'required|unique:tbl_category_product,category_product_slug',
            'category_product_parent' => 'required',
            'category_product_status' => 'required|in:0,1',
        ], [
            'category_product_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $category_parent = CategoryProduct::where('category_product_id', $request->category_product_parent)->first();

            if($category_parent || $request->category_product_parent == 0) {
                $category_product = CategoryProduct::create($request->all());
                return $this->successResponse($category_product, 'Thêm danh mục thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy danh mục cha!', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm danh mục ' . $e->getMessage(), 500);
        }
    }

    public function edit_category_product(Request $request)
    {
        $request->validate([
            'category_product_id' => 'required|exists:tbl_category_product,category_product_id',
            'category_product_name' => 'required',
            'category_product_slug' => 'required|unique:tbl_category_product,category_product_slug,' . $request->category_product_id . ',category_product_id',
            'category_product_parent' => 'required',
            'category_product_status' => 'required|in:0,1',
        ], [
            'category_product_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $category_parent = CategoryProduct::where('category_product_id', $request->category_product_parent)->first();

            if($category_parent || $request->category_product_parent == 0) {
                $category_product = CategoryProduct::where('category_product_id', $request->category_product_id)->update([
                    'category_product_name' => $request->category_product_name,
                    'category_product_slug' => $request->category_product_slug,
                    'category_product_parent' => $request->category_product_parent,
                    'category_product_status' => $request->category_product_status,
                ]);

                return $this->successResponse($category_product, 'Cập nhật danh mục thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy danh mục cha!', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật danh mục ' . $e->getMessage(), 500);
        }
    }

    public function delete_category_product(Request $request)
    {
        $request->validate([
            'category_product_id' => 'required|exists:tbl_category_product,category_product_id',
        ]);

        try {
            $deleted = CategoryProduct::destroy($request->category_product_id);
            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            return $this->successResponse(null, 'Xóa danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa danh mục ' . $e->getMessage(), 500);
        }
    }

    public function active_category_product($id)
    {
        try {
            $category_product = CategoryProduct::find($id);
            if (!$category_product) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            $category_product->update([
                'category_product_status' => 1,
            ]);
            return $this->successResponse($category_product, 'Hiển thị danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị danh mục ' . $e->getMessage(), 500);
        }
    }

    public function unactive_category_product($id)
    {
        try {
            $category_product = CategoryProduct::find($id);
            if (!$category_product) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            $category_product->update([
                'category_product_status' => 0,
            ]);
            return $this->successResponse($category_product, 'Ẩn danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn danh mục ' . $e->getMessage(), 500);
        }
    }

    public function load_category_product_user()
    {
        try {
            $category_product = CategoryProduct::where('category_product_status', 1)->get();
            return $this->successResponse($category_product, 'Lấy tất cả danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả danh mục ' . $e->getMessage(), 500);
        }
    }

    public function get_product_by_category_user(Request $request)
    {
        $order_by = $request->order_by;

        if($order_by == 'sold') {
            $product = Product::where('product_status', 1)->where('category_product_id', $request->category_product_id)->orderBy('product_sold', 'desc')->paginate($this->linePerPageUser);
        } elseif($order_by == 'new') {
            $product = Product::where('product_status', 1)->where('category_product_id', $request->category_product_id)->orderBy('product_id', 'desc')->paginate($this->linePerPageUser);
        } else {
            $product = Product::where('product_status', 1)->where('category_product_id', $request->category_product_id)
            ->orderByRaw('IF(CAST(product_price_discount AS SIGNED) != 0, CAST(product_price_discount AS SIGNED), CAST(product_price AS SIGNED)) ' . $order_by)
            ->paginate($this->linePerPageUser);
        }

        return $this->successResponse($product, 'Lấy tất cả sản phẩm thành công!', 200);
    }

    public function show_page_category_product_user($category_product_slug)
    {
        $category_product = CategoryProduct::where('category_product_slug', $category_product_slug)->first();
        return view('user.product.show_product_by_category', compact('category_product'));
    }
}
