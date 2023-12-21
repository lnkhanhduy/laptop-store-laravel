<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();
class VoucherController extends Controller
{
    use UtilitiesTrait;

    public function show_page_voucher()
    {
        return view('admin.voucher.all_voucher');
    }

    public function get_all_voucher(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_voucher = Voucher::orderBy('voucher_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_voucher = Voucher::orderBy('voucher_id', 'desc')->get();
            }

            return $this->successResponse($all_voucher, 'Lấy tất cả mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function get_all_voucher_by_status($status, Request $request)
    {
        if ($status != 2 && $status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_voucher = Voucher::where('voucher_status', $status)->orderBy('voucher_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_voucher, 'Lấy mã giảm giá thành công 2!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function get_voucher_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $voucher = Voucher::where('voucher_id', $id)->first();
            if ($voucher) {
                return $this->successResponse($voucher, 'Lấy thông tin mã giảm giá thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy mã giảm giá!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin mã giảm giá thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_voucher($keyword)
    {
        try {
            $all_voucher = Voucher::where('voucher_name', 'like', '%' . $keyword . '%')->orWhere('voucher_code', 'like', '%' . $keyword . '%')->orderBy('voucher_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_voucher, 'Danh sách mã giảm giá được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function add_voucher(Request $request)
    {
        $request->validate([
            'voucher_name' => 'required',
            'voucher_code' => 'required|unique:tbl_voucher',
            'voucher_quantity' => 'required',
            'voucher_type' => 'required',
            'voucher_discount_amount' => 'required',
            'voucher_status' => 'required|in:0,1',
        ], [
            'voucher_code.unique' => 'Mã giảm giá đã được sử dụng!',
        ]);

        try {
            $voucher = Voucher::create([
                'voucher_name' => $request->voucher_name,
                'voucher_code' => $request->voucher_code,
                'voucher_quantity' => $request->voucher_quantity,
                'voucher_used' => 0,
                'voucher_used_by_user' => '',
                'voucher_type' => $request->voucher_type,
                'voucher_discount_amount' => $request->voucher_discount_amount,
                            'voucher_status' => $request->voucher_status,
            ]);
            return $this->successResponse($voucher, 'Thêm mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function edit_voucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|exists:tbl_voucher,voucher_id',
            'voucher_name' => 'required',
            'voucher_slug' => 'required|unique:tbl_voucher,voucher_slug,' . $request->voucher_id . ',voucher_id',
            'category_voucher_id' => 'required|exists:tbl_category_voucher,category_voucher_id',
            'brand_id' => 'required|exists:tbl_brand,brand_id',
            'voucher_quantity' => 'required',
            'voucher_desc' => 'required',
            'voucher_content' => 'required',
            'voucher_cost' => 'required',
            'voucher_price' => 'required|gt:voucher_cost',
            'voucher_status' => 'required|in:0,1',
        ], [
            'voucher_slug.unique' => 'Slug đã được sử dụng!',
            'voucher_price.gt' => 'Giá bán phải lớn hơn giá nhập!'
        ]);

        try {
            $voucher = Voucher::find($request->voucher_id);
            if ($voucher && $request->voucher_quantity <= $voucher->voucher_sold) {
                return $this->errorResponse('Số lượng sản phẩm phải lớn hơn đã bán!', 500);
            }

            $get_image = $request->file('voucher_image');

            if($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/vouchers', $new_image_name);

                //Delete old image
                $old_image = Voucher::where('voucher_id', $request->voucher_id)->first();

                if ($old_image) {
                    $old_image_path = public_path('uploads/vouchers') . '/' . $old_image->voucher_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                //End delete old image

                $voucher = $voucher->update([
                    'voucher_name' => $request->voucher_name,
                    'voucher_slug' => $request->voucher_slug,
                    'category_voucher_id' => $request->category_voucher_id,
                    'brand_id' => $request->brand_id,
                    'voucher_quantity' => $request->voucher_quantity,
                    'voucher_desc' => $request->voucher_desc,
                    'voucher_content' => $request->voucher_content,
                    'voucher_cost' => $request->voucher_cost,
                    'voucher_price' => $request->voucher_price,
                    'voucher_status' => $request->voucher_status,
                    'voucher_image' => $new_image_name,
                ]);

            } else {
                $voucher = $voucher->update([
                    'voucher_name' => $request->voucher_name,
                    'voucher_slug' => $request->voucher_slug,
                    'category_voucher_id' => $request->category_voucher_id,
                    'brand_id' => $request->brand_id,
                    'voucher_quantity' => $request->voucher_quantity,
                    'voucher_desc' => $request->voucher_desc,
                    'voucher_content' => $request->voucher_content,
                    'voucher_cost' => $request->voucher_cost,
                    'voucher_price' => $request->voucher_price,
                    'voucher_status' => $request->voucher_status,
                             ]);
            }
            return $this->successResponse($voucher, 'Cập nhật mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function delete_voucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|exists:tbl_voucher,voucher_id',
        ]);

        try {
            $voucher = Voucher::find($request->voucher_id);
            $deleted = $voucher->delete();

            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy mã giảm giá!', 404);
            }

            // Delete old image
            if ($voucher->voucher_image) {
                $old_image_path = public_path('uploads/vouchers') . '/' . $voucher->voucher_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            // End delete old image

            return $this->successResponse(null, 'Xóa mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function active_voucher($id)
    {
        try {
            $voucher = Voucher::find($id);
            if (!$voucher) {
                return $this->errorResponse('Không tìm thấy mã giảm giá!', 404);
            }

            if($voucher->voucher_status == 0) {
                $voucher->update([
                    'voucher_status' => 1,
                ]);
            }
            return $this->successResponse($voucher, 'Kích hoạt mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi kích hoạt mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function unactive_voucher($id)
    {
        try {
            $voucher = Voucher::find($id);
            if (!$voucher) {
                return $this->errorResponse('Không tìm thấy mã giảm giá!', 404);
            }

            if($voucher->voucher_status == 1) {
                $voucher->update([
                    'voucher_status' => 0,
                ]);
            }

            return $this->successResponse($voucher, 'Hủy kích hoạt mã giảm giá thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hủy kích hoạt mã giảm giá ' . $e->getMessage(), 500);
        }
    }

    public function check_discount_code_user(Request $request)
    {
        $user_id = Session::get('user_id');
        $data_user_used_voucher = [];
        $voucher = Voucher::where('voucher_code', $request->code_discount)->first();

        if($voucher != null && $voucher->voucher_used_by_user != null) {
            $data_user_used_voucher = explode(",", $voucher->voucher_used_by_user);
        }
        if($voucher == null || $voucher->voucher_status == 0) {
            return $this->errorResponse('Mã giảm giá không đúng!', 422);
        } elseif($voucher->voucher_status == 2) {
            return $this->errorResponse('Mã giảm giá đã được sử dụng hết!', 422);
        } elseif(in_array($user_id, $data_user_used_voucher)) {
            return $this->errorResponse('Bạn đã sử dụng mã giảm giá này!', 422);
        }

        return $this->successResponse($voucher, 'Lấy mã giảm giá thành công!', 200);
    }
}
