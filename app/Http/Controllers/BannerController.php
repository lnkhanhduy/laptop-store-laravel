<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class BannerController extends Controller
{
    use UtilitiesTrait;

    public function show_page_banner()
    {
        return view('admin.banner.all_banner');
    }

    public function get_all_banner(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_banner = Banner::orderBy('banner_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_banner = Banner::orderBy('banner_id', 'desc')->get();
            }

            return $this->successResponse($all_banner, 'Lấy tất cả banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả banner ' . $e->getMessage(), 500);
        }
    }

    public function get_all_banner_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_banner = Banner::where('banner_status', $status)->orderBy('banner_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_banner, 'Lấy banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy banner ' . $e->getMessage(), 500);
        }
    }

    public function get_banner_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $banner = Banner::where('banner_id', $id)->first();
            if ($banner) {
                return $this->successResponse($banner, 'Lấy thông tin banner thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy banner!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin banner thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_banner($keyword)
    {
        try {
            $all_banner = Banner::where('banner_name', 'like', '%' . $keyword . '%')->orderBy('banner_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_banner, 'Danh sách banner được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm banner ' . $e->getMessage(), 500);
        }
    }

    public function add_banner(Request $request)
    {
        $request->validate([
            'banner_name' => 'required',
            'banner_status' => 'required|in:0,1',
        ]);

        try {
            $get_image = $request->file('banner_image');

            if($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/banner', $new_image_name);

                $banner = Banner::create([
                    'banner_name' => $request->banner_name,
                    'banner_image' => $new_image_name,
                    'banner_status' => $request->banner_status,
                ]);
                return $this->successResponse($banner, 'Thêm banner thành công!', 200);
            }
            return $this->errorResponse('Vui lòng chọn hình ảnh banner!', 500);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm banner ' . $e->getMessage(), 500);
        }
    }

    public function edit_banner(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:tbl_banner,banner_id',
            'banner_name' => 'required',
            'banner_status' => 'required|in:0,1',
        ]);

        try {
            $banner = Banner::find($request->banner_id);

            $get_image = $request->file('banner_image');

            if($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/banner', $new_image_name);

                //Delete old image
                $old_image = Banner::where('banner_id', $request->banner_id)->first();

                if ($old_image) {
                    $old_image_path = public_path('uploads/banner') . '/' . $old_image->banner_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                //End delete old image

                $banner = $banner->update([
                    'banner_name' => $request->banner_name,
                    'banner_image' => $new_image_name,
                    'banner_status' => $request->banner_status,
                ]);

            } else {
                $banner = $banner->update([
                    'banner_name' => $request->banner_name,
                    'banner_status' => $request->banner_status,
                ]);
            }
            return $this->successResponse($banner, 'Cập nhật banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật banner ' . $e->getMessage(), 500);
        }
    }

    public function delete_banner(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:tbl_banner,banner_id',
        ]);

        try {
            $banner = Banner::find($request->banner_id);
            $deleted = $banner->delete();

            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy banner!', 404);
            }

            // Delete old image
            if ($banner->banner_image) {
                $old_image_path = public_path('uploads/banner') . '/' . $banner->banner_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            // End delete old image

            return $this->successResponse(null, 'Xóa banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa banner ' . $e->getMessage(), 500);
        }
    }

    public function active_banner($id)
    {
        try {
            $banner = Banner::find($id);
            if (!$banner) {
                return $this->errorResponse('Không tìm thấy banner!', 404);
            }

            $banner->update([
                'banner_status' => 1,
            ]);
            return $this->successResponse($banner, 'Hiển thị banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị banner ' . $e->getMessage(), 500);
        }
    }

    public function unactive_banner($id)
    {
        try {
            $banner = Banner::find($id);
            if (!$banner) {
                return $this->errorResponse('Không tìm thấy banner!', 404);
            }

            $banner->update([
                'banner_status' => 0,
            ]);
            return $this->successResponse($banner, 'Ẩn banner thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn banner ' . $e->getMessage(), 500);
        }
    }
}
