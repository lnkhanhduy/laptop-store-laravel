<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Gallery;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class ProductController extends Controller
{
    use UtilitiesTrait;

    public function show_page_product()
    {
        return view('admin.product.all_product');
    }

    public function get_all_product(Request $request)
    {
        try {
            if ($request->pagination && $request->pagination == "true") {
                $all_product = Product::orderBy('product_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_product = Product::orderBy('product_id', 'desc')->get();
            }

            return $this->successResponse($all_product, 'Lấy tất cả sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function get_all_product_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_product = Product::where('product_status', $status)->orderBy('product_id', 'desc')->paginate($this->linePerPageAdmin);
            foreach ($all_product as $key => $value) {
                $value->parent_name = $value->getNameCategory->product_name ?? 'Danh mục cha';
            }
            return $this->successResponse($all_product, 'Lấy sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function get_product_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $product = Product::where('product_id', $id)->first();
            if ($product) {
                return $this->successResponse($product, 'Lấy thông tin sản phẩm thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy sản phẩm!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin sản phẩm thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_product($keyword)
    {
        try {
            $all_product = Product::where('product_name', 'like', '%' . $keyword . '%')->orWhere('product_slug', 'like', '%' . $keyword . '%')->orderBy('product_id', 'desc')->paginate($this->linePerPageAdmin);
            foreach ($all_product as $key => $value) {
                $value->parent_name = $value->getNameCategory->product_name ?? 'Danh mục cha';
            }
            return $this->successResponse($all_product, 'Danh sách sản phẩm được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_slug' => 'required|unique:tbl_product,product_slug',
            'category_product_id' => 'required|exists:tbl_category_product,category_product_id',
            'brand_id' => 'required|exists:tbl_brand,brand_id',
            'product_quantity' => 'required',
            'product_desc' => 'required',
            'product_cost' => 'required',
            'product_price' => 'required|gt:product_cost',
            'product_image' => 'required',
            'product_status' => 'required|in:0,1',
        ], [
            'product_slug.unique' => 'Slug đã được sử dụng!',
            'product_price.gt' => 'Giá bán phải lớn hơn giá nhập!'
        ]);

        try {
            $get_image = $request->file('product_image');

            if ($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/product', $new_image_name);

                $product = Product::create([
                    'product_name' => $request->product_name,
                    'product_slug' => $request->product_slug,
                    'category_product_id' => $request->category_product_id,
                    'brand_id' => $request->brand_id,
                    'product_quantity' => $request->product_quantity,
                    'product_sold' => 0,
                    'product_desc' => $request->product_desc,
                    'product_cost' => $request->product_cost,
                    'product_price' => $request->product_price,
                    'product_price_discount' => $request->product_price_discount ? $request->product_price_discount : '0',
                    'product_status' => $request->product_status,
                    'product_image' => $new_image_name,
                    'product_views' => 0
                ]);
                return $this->successResponse($product, 'Thêm sản phẩm thành công!', 200);
            }
            return $this->errorResponse('Vui lòng chọn hình ảnh sản phẩm!', 500);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function edit_product(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_product,product_id',
            'product_name' => 'required',
            'product_slug' => 'required|unique:tbl_product,product_slug,' . $request->product_id . ',product_id',
            'category_product_id' => 'required|exists:tbl_category_product,category_product_id',
            'brand_id' => 'required|exists:tbl_brand,brand_id',
            'product_quantity' => 'required',
            'product_desc' => 'required',
            'product_cost' => 'required',
            'product_price' => 'required|gt:product_cost',
            'product_status' => 'required|in:0,1',
        ], [
            'product_slug.unique' => 'Slug đã được sử dụng!',
            'product_price.gt' => 'Giá bán phải lớn hơn giá nhập!'
        ]);

        try {
            $product = Product::find($request->product_id);
            if ($product && $request->product_quantity <= $product->product_sold) {
                return $this->errorResponse('Số lượng sản phẩm phải lớn hơn đã bán!', 500);
            }

            $get_image = $request->file('product_image');

            if ($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/product', $new_image_name);

                //Delete old image
                $old_image = Product::where('product_id', $request->product_id)->first();

                if ($old_image) {
                    $old_image_path = public_path('uploads/product') . '/' . $old_image->product_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                //End delete old image

                $product = $product->update([
                    'product_name' => $request->product_name,
                    'product_slug' => $request->product_slug,
                    'category_product_id' => $request->category_product_id,
                    'brand_id' => $request->brand_id,
                    'product_quantity' => $request->product_quantity,
                    'product_desc' => $request->product_desc,
                    'product_cost' => $request->product_cost,
                    'product_price' => $request->product_price,
                    'product_price_discount' => $request->product_price_discount ? $request->product_price_discount : '0',
                    'product_status' => $request->product_status,
                    'product_image' => $new_image_name,
                ]);

            } else {
                $product = $product->update([
                    'product_name' => $request->product_name,
                    'product_slug' => $request->product_slug,
                    'category_product_id' => $request->category_product_id,
                    'brand_id' => $request->brand_id,
                    'product_quantity' => $request->product_quantity,
                    'product_desc' => $request->product_desc,
                    'product_cost' => $request->product_cost,
                    'product_price' => $request->product_price,
                    'product_price_discount' => $request->product_price_discount ? $request->product_price_discount : '0',
                    'product_status' => $request->product_status,
                ]);
            }
            return $this->successResponse($product, 'Cập nhật sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function delete_product(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_product,product_id',
        ]);

        try {
            $product = Product::find($request->product_id);
            $deleted = $product->delete();

            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy sản phẩm!', 404);
            }

            // Delete old image
            if ($product->product_image) {
                $old_image_path = public_path('uploads/product') . '/' . $product->product_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            // End delete old image

            return $this->successResponse(null, 'Xóa sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function active_product($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return $this->errorResponse('Không tìm thấy sản phẩm!', 404);
            }

            $product->update([
                'product_status' => 1,
            ]);
            return $this->successResponse($product, 'Hiển thị sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị sản phẩm ' . $e->getMessage(), 500);
        }
    }

    public function unactive_product($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return $this->errorResponse('Không tìm thấy sản phẩm!', 404);
            }

            $product->update([
                'product_status' => 0,
            ]);
            return $this->successResponse($product, 'Ẩn sản phẩm thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn sản phẩm ' . $e->getMessage(), 500);
        }
    }


    // User function

    public function show_page_detail_product($product_slug)
    {
        $product = Product::where('product_slug', $product_slug)->with('getBrandName')->first();
        $product->increment('product_views', 1);
        $gallery = Gallery::where('product_id', $product->product_id)->get();
        $related_product = Product::where('product_status', 1)->where('category_product_id', $product->category_product_id)->where('product_id', '!=', $product->product_id)->limit(4)->get();

        return view('user.product.show_detail_product', [
            'product' => $product,
            'gallery' => $gallery,
            'related_product' => $related_product
        ]);
    }

    public function get_product_user(Request $request)
    {
        $order_by = $request->order_by;

        if ($order_by == 'sold') {
            $product = Product::where('product_status', 1)->orderBy('product_sold', 'desc')->paginate($this->linePerPageUser);
        } elseif ($order_by == 'new') {
            $product = Product::where('product_status', 1)->orderBy('product_id', 'desc')->paginate($this->linePerPageUser);
        } else {
            $product = Product::where('product_status', 1)
                ->orderByRaw('IF(CAST(product_price_discount AS SIGNED) != 0, CAST(product_price_discount AS SIGNED), CAST(product_price AS SIGNED)) ' . $order_by)
                ->paginate($this->linePerPageUser);
        }

        return $this->successResponse($product, 'Lấy tất cả sản phẩm thành công!', 200);
    }

    public function search_product_user(Request $request)
    {
        $order_by = $request->order_by;

        if ($order_by == 'sold') {
            $product = Product::with('getBrandName')
                ->with('getCategoryName')
                ->where(function ($query) use ($request) {
                    $query->where('product_name', 'like', '%' . $request->keyword . '%')
                        ->orWhereHas('getBrandName', function ($brandQuery) use ($request) {
                            $brandQuery->where('brand_name', 'like', '%' . $request->keyword . '%');
                        })
                        ->orWhereHas('getCategoryName', function ($categoryQuery) use ($request) {
                            $categoryQuery->where('category_product_name', 'like', '%' . $request->keyword . '%');
                        });
                })
                ->orderBy('product_sold', 'desc')->paginate($this->linePerPageUser);
        } elseif ($order_by == 'new') {
            $product = Product::with('getBrandName')
                ->with('getCategoryName')
                ->where(function ($query) use ($request) {
                    $query->where('product_name', 'like', '%' . $request->keyword . '%')
                        ->orWhereHas('getBrandName', function ($brandQuery) use ($request) {
                            $brandQuery->where('brand_name', 'like', '%' . $request->keyword . '%');
                        })
                        ->orWhereHas('getCategoryName', function ($categoryQuery) use ($request) {
                            $categoryQuery->where('category_product_name', 'like', '%' . $request->keyword . '%');
                        });
                })
                ->orderBy('product_id', 'desc')->paginate($this->linePerPageUser);
        } else {
            $product = Product::with('getBrandName')
                ->with('getCategoryName')
                ->where(function ($query) use ($request) {
                    $query->where('product_name', 'like', '%' . $request->keyword . '%')
                        ->orWhereHas('getBrandName', function ($brandQuery) use ($request) {
                            $brandQuery->where('brand_name', 'like', '%' . $request->keyword . '%');
                        })
                        ->orWhereHas('getCategoryName', function ($categoryQuery) use ($request) {
                            $categoryQuery->where('category_product_name', 'like', '%' . $request->keyword . '%');
                        });
                })
                ->orderByRaw('IF(CAST(product_price_discount AS SIGNED) != 0, CAST(product_price_discount AS SIGNED), CAST(product_price AS SIGNED)) ' . $order_by)->paginate($this->linePerPageUser);
        }

        return $this->successResponse($product, 'Lấy tất cả sản phẩm thành công!', 200);
    }
}