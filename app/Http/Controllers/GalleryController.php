<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class GalleryController extends Controller
{
    use UtilitiesTrait;

    public function show_gallery($product_slug)
    {
        return view('admin.gallery.gallery_product')->with(compact('product_slug'));
    }

    public function get_all_gallery($product_slug)
    {
        try {
            $product = Product::where('product_slug', $product_slug)->first();

            if($product) {
                $all_gallery = Gallery::where('product_id', $product->product_id)->orderBy('gallery_id', 'desc')->get();
                return $this->successResponse($all_gallery, 'Lấy tất cả gallery thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy sản phẩm!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả gallery ' . $e->getMessage(), 500);
        }
    }

    public function add_gallery(Request $request)
    {
        $request->validate([
            'product_slug' => 'required|exists:tbl_product,product_slug',
        ]);

        $get_image = $request->file('gallery_image');
        if($get_image) {
            try {
                $product = Product::where('product_slug', $request->product_slug)->first();
                foreach($get_image as $image) {
                    $old_image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $image_extension = $image->getClientOriginalExtension();
                    $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                    $image->move('public/uploads/gallery', $new_image_name);

                    $gallery = new Gallery();
                    $gallery->gallery_image = $new_image_name;
                    $gallery->product_id = $product->product_id;
                    $gallery->save();
                }

                return $this->successResponse(null, 'Thêm gallery thành công!', 200);
            } catch (\Exception $e) {
                return $this->errorResponse('Có lỗi xảy ra khi thêm gallery ' . $e->getMessage(), 500);
            }
        } else {
            return $this->errorResponse('Vui lòng chọn hình ảnh!', 500);
        }
    }

    public function edit_gallery(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:tbl_gallery,gallery_id',
        ]);

        $get_image = $request->file('gallery_image');
        if($get_image) {
            try {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/gallery', $new_image_name);

                //Delete old image
                $gallery_id = $request->gallery_id;
                $old_image = Gallery::where('gallery_id', $gallery_id)->first();

                if ($old_image) {
                    $old_image_path = public_path('uploads/gallery') . '/' . $old_image->gallery_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                //End delete old image

                Gallery::where('gallery_id', $gallery_id)->update([
                    'gallery_image' => $new_image_name
                ]);

                return $this->successResponse(null, 'Sửa gallery thành công!', 200);
            } catch (\Exception $e) {
                return $this->errorResponse('Có lỗi xảy ra khi thêm gallery ' . $e->getMessage(), 500);
            }
        } else {
            return $this->errorResponse('Vui lòng chọn hình ảnh!', 500);
        }
    }

    public function delete_gallery(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:tbl_gallery,gallery_id',
        ]);

        try {
            $gallery = Gallery::find($request->gallery_id);
            $deleted = $gallery->delete();

            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy gallery!', 404);
            }

            // Delete old image
            if ($gallery->gallery_image) {
                $old_image_path = public_path('uploads/gallery') . '/' . $gallery->gallery_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            // End delete old image

            return $this->successResponse(null, 'Xóa gallery thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa  gallery ' . $e->getMessage(), 500);
        }
    }
}
