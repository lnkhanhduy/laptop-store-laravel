<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\CategoryPost;

session_start();

class PostController extends Controller
{
    use UtilitiesTrait;

    public function show_page_post()
    {
        return view('admin.post.all_post');
    }

    public function show_page_add_post()
    {
        $category_post = CategoryPost::where('category_post_status', 1)->orderBy('category_post_id', 'desc')->get();
        return view('admin.post.add_post')->with(compact('category_post'));
    }

    public function show_page_edit_post($post_id)
    {
        $category_post = CategoryPost::where('category_post_status', 1)->orderBy('category_post_id', 'desc')->get();
        $post_item = Post::where('post_id', $post_id)->get();
        return view('admin.post.edit_post')->with(compact('category_post', 'post_item'));
    }

    public function show_page_detail_post($post_id)
    {
        $post_item = Post::with('getCategoryName')->where('post_id', $post_id)->get();
        return view('admin.post.view_post')->with(compact('post_item'));
    }

    public function get_all_post(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_post = Post::orderBy('post_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_post = Post::orderBy('post_id', 'desc')->get();
            }

            return $this->successResponse($all_post, 'Lấy tất cả bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả bài viết ' . $e->getMessage(), 500);
        }
    }

    public function get_all_post_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_post = Post::where('post_status', $status)->orderBy('post_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_post, 'Lấy bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy bài viết ' . $e->getMessage(), 500);
        }
    }

    public function search_post($keyword)
    {
        try {
            $all_post = Post::where('post_title', 'like', '%' . $keyword . '%')->orWhere('post_slug', 'like', '%' . $keyword . '%')->orderBy('post_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_post, 'Danh sách bài viết được tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm bài viết ' . $e->getMessage(), 500);
        }
    }

    public function add_post(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'post_slug' => 'required|unique:tbl_post,post_slug',
            'post_desc' => 'required',
            'post_content' => 'required',
            'category_post_id' => 'required|exists:tbl_category_post,category_post_id',
            'post_status' => 'required|in:0,1',
        ], [
            'post_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $get_image = $request->file('post_image');

            if($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/post', $new_image_name);

                $post = Post::create([
                    'post_title' => $request->post_title,
                    'post_slug' => $request->post_slug,
                    'post_desc' => $request->post_desc,
                    'post_content' => $request->post_content,
                    'post_image' => $new_image_name,
                    'category_post_id' => $request->category_post_id,
                    'post_views' => 0,
                    'post_status' => $request->post_status,
                ]);
                return $this->successResponse($post, 'Thêm bài viết thành công!', 200);
            }
            return $this->errorResponse('Vui lòng chọn hình ảnh bài viết!', 500);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm bài viết ' . $e->getMessage(), 500);
        }
    }

    public function edit_post(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:tbl_post,post_id',
            'post_title' => 'required',
            'post_slug' => 'required|unique:tbl_post,post_slug,' . $request->post_id . ',post_id',
            'post_desc' => 'required',
            'post_content' => 'required',
            'category_post_id' => 'required|exists:tbl_category_post,category_post_id',
            'post_status' => 'required|in:0,1',
        ], [
            'post_slug.unique' => 'Slug đã được sử dụng!',
        ]);

        try {
            $get_image = $request->file('post_image');

            if($get_image) {
                $old_image_name = pathinfo($get_image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $get_image->getClientOriginalExtension();
                $new_image_name = $old_image_name . '_' . time() . '.' . $image_extension;

                $get_image->move('public/uploads/post', $new_image_name);

                //Delete old image
                $old_image = Post::where('post_id', $request->post_id)->first();

                if ($old_image) {
                    $old_image_path = public_path('uploads/post') . '/' . $old_image->post_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                //End delete old image

                $post = Post::where('post_id', $request->post_id)->update([
                    'post_title' => $request->post_title,
                    'post_slug' => $request->post_slug,
                    'post_desc' => $request->post_desc,
                    'post_content' => $request->post_content,
                    'post_image' => $new_image_name,
                    'category_post_id' => $request->category_post_id,
                    'post_status' => $request->post_status,
                ]);

            } else {
                $post = Post::where('post_id', $request->post_id)->update([
                    'post_title' => $request->post_title,
                    'post_slug' => $request->post_slug,
                    'post_desc' => $request->post_desc,
                    'post_content' => $request->post_content,
                    'category_post_id' => $request->category_post_id,
                    'post_status' => $request->post_status,
                ]);
            }
            return $this->successResponse($post, 'Cập nhật bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi cập nhật bài viết ' . $e->getMessage(), 500);
        }
    }

    public function delete_post(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:tbl_post,post_id',
        ]);

        try {
            $post = Post::find($request->post_id);
            $deleted = $post->delete();

            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy bài viết!', 404);
            }

            // Delete old image
            if ($post->post_image) {
                $old_image_path = public_path('uploads/post') . '/' . $post->post_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            // End delete old image

            return $this->successResponse(null, 'Xóa bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa bài viết ' . $e->getMessage(), 500);
        }
    }

    public function active_post($id)
    {
        try {
            $post = Post::find($id);
            if (!$post) {
                return $this->errorResponse('Không tìm thấy bài viết!', 404);
            }

            $post->update([
                'post_status' => 1,
            ]);
            return $this->successResponse($post, 'Hiển thị bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi hiển thị bài viết ' . $e->getMessage(), 500);
        }
    }

    public function unactive_post($id)
    {
        try {
            $post = Post::find($id);
            if (!$post) {
                return $this->errorResponse('Không tìm thấy bài viết!', 404);
            }

            $post->update([
                'post_status' => 0,
            ]);
            return $this->successResponse($post, 'Ẩn bài viết thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi ẩn bài viết ' . $e->getMessage(), 500);
        }
    }

    public function show_page_all_post_user()
    {
        return view('user.post.show_all_post');
    }

    public function get_all_post_user(Request $request)
    {
        $order_by = $request->order_by;

        if($order_by == 'new') {
            $post = Post::where('post_status', 1)->orderBy('post_id', 'desc')->paginate($this->linePerPageUser);
        } else {
            $post = Post::where('post_status', 1)->orderBy('post_views', 'desc')
            ->paginate($this->linePerPageUser);
        }

        return $this->successResponse($post, 'Lấy tất cả bài viết thành công!', 200);
    }

    public function get_detail_post_user($post_slug)
    {
        $post = Post::where('post_slug', $post_slug)->with('getCategoryName')->first();
        $post->increment('post_views', 1);
        $related_post = Post::where('category_post_id', $post->category_post_id)->where('post_status', 1)->where('post_id', '!=', $post->post_id)->orderBy('post_id', 'desc')->take(4)->get();
        return view('user.post.show_detail_post', [
            'post' => $post,
            'related_post' => $related_post
        ]);
    }
}
