<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPost;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class CategoryPostController extends Controller
{
    use UtilitiesTrait;

    public function show_page_category_post()
    {
        return view('admin.category_post.all_category_post');
    }

    public function get_all_category_post(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_category_post = CategoryPost::orderBy('category_post_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_category_post = CategoryPost::orderBy('category_post_id', 'desc')->get();
            }

            return $this->successResponse($all_category_post, 'Lấy tất cả danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả danh mục ' . $e->getMessage(), 500);
        }
    }

    public function get_all_category_post_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_category_post = CategoryPost::where('category_post_status', $status)->orderBy('category_post_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_category_post, 'Lấy danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy danh mục ' . $e->getMessage(), 500);
        }
    }

    public function get_category_post_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $category_post = CategoryPost::where('category_post_id', $id)->first();
            if ($category_post) {
                return $this->successResponse($category_post, 'Lấy thông tin danh mục thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy danh mục!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin danh mục thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_category_post($keyword)
    {
        try {
            $all_category_post = CategoryPost::where('category_post_name', 'like', '%' . $keyword . '%')->orWhere('category_post_slug', 'like', '%' . $keyword . '%')->orderBy('category_post_id', 'desc')->paginate($this->linePerPageAdmin);

            return $this->successResponse($all_category_post, 'Danh sách danh mục được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm danh mục ' . $e->getMessage(), 500);
        }
    }

    public function add_category_post(Request $request)
    {
        $request->validate([
            'category_post_name' => 'required',
            'category_post_slug' => 'required|unique:tbl_category_post,category_post_slug',
            'category_post_status' => 'required|in:0,1',
        ], [
            'category_post_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $category_post = CategoryPost::create($request->all());
            return $this->successResponse($category_post, 'Thêm danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm danh mục ' . $e->getMessage(), 500);
        }
    }

    public function edit_category_post(Request $request)
    {
        $request->validate([
            'category_post_id' => 'required|exists:tbl_category_post,category_post_id',
            'category_post_name' => 'required',
            'category_post_slug' => 'required|unique:tbl_category_post,category_post_slug,' . $request->category_post_id . ',category_post_id',
            'category_post_status' => 'required|in:0,1',
        ], [
            'category_post_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $category_post = CategoryPost::where('category_post_id', $request->category_post_id)->update([
                'category_post_name' => $request->category_post_name,
                'category_post_slug' => $request->category_post_slug,
                'category_post_status' => $request->category_post_status,
            ]);

            return $this->successResponse($category_post, 'Cập nhật danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật danh mục ' . $e->getMessage(), 500);
        }
    }

    public function delete_category_post(Request $request)
    {
        $request->validate([
            'category_post_id' => 'required|exists:tbl_category_post,category_post_id',
        ]);

        try {
            $deleted = CategoryPost::destroy($request->category_post_id);
            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            return $this->successResponse(null, 'Xóa danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa danh mục ' . $e->getMessage(), 500);
        }
    }

    public function active_category_post($id)
    {
        try {
            $category_post = CategoryPost::find($id);
            if (!$category_post) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            $category_post->update([
                'category_post_status' => 1,
            ]);
            return $this->successResponse($category_post, 'Hiển thị danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị danh mục ' . $e->getMessage(), 500);
        }
    }

    public function unactive_category_post($id)
    {
        try {
            $category_post = CategoryPost::find($id);
            if (!$category_post) {
                return $this->errorResponse('Không tìm thấy danh mục!', 404);
            }

            $category_post->update([
                'category_post_status' => 0,
            ]);
            return $this->successResponse($category_post, 'Ẩn danh mục thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn danh mục ' . $e->getMessage(), 500);
        }
    }
}
