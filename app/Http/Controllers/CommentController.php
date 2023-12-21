<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class CommentController extends Controller
{
    use UtilitiesTrait;
    public function show_page_comment()
    {
        return view('admin.comment.all_comment');
    }

    public function get_all_comment(Request $request)
    {
        try {
            if($request->pagination && $request->pagination == "true") {
                $all_comment = Comment::with('getProduct')->orderBy('comment_id', 'desc')->paginate($this->linePerPageAdmin);
            } else {
                $all_comment = Comment::orderBy('comment_id', 'desc')->get();
            }

            return $this->successResponse($all_comment, 'Lấy tất cả bình luận thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả bình luận ' . $e->getMessage(), 500);
        }
    }

    public function get_all_comment_by_status($status)
    {
        if ($status != 1 && $status != 0) {
            return $this->errorResponse('Trạng thái không hợp lệ!', 500);
        }

        try {
            $all_comment = Comment::where('comment_status', $status)->orderBy('comment_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_comment, 'Lấy bình luận đang ' . $status == 1 ? 'hiển thị' : 'ẩn' . ' thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy bình luận đang ' . $status == 1 ? 'hiển thị' : 'ẩn' . ' hiển thị ' . $e->getMessage(), 500);
        }
    }

    public function get_comment_by_id($id)
    {
        if (!is_numeric($id)) {
            return $this->errorResponse('ID không hợp lệ!', 500);
        }

        try {
            $comment = Comment::where('comment_id', $id)->first();
            if ($comment) {
                return $this->successResponse($comment, 'Lấy thông tin bình luận thành công!', 200);
            } else {
                return $this->errorResponse('Không tìm thấy bình luận!', 500);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy thông tin bình luận thành công ' . $e->getMessage(), 500);
        }
    }

    public function search_comment($keyword)
    {
        try {
            $all_comment = Comment::where('comment_content', 'like', '%' . $keyword . '%')->orWhere('comment_reply', 'like', '%' . $keyword . '%')->orderBy('comment_id', 'desc')->paginate($this->linePerPageAdmin);
            return $this->successResponse($all_comment, 'Danh sách bình luận tìm thấy!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi tìm bình luận ' . $e->getMessage(), 500);
        }
    }

    public function reply_comment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:tbl_comment,comment_id',
            'comment_reply' => 'required',
        ]);

        try {
            $comment = Comment::where('comment_id', $request->comment_id)->update([
                'comment_reply' => $request->comment_reply,
                'comment_status' => 1,
            ]);

            return $this->successResponse($comment, 'Cập nhật bình luận thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm bình luận ' . $e->getMessage(), 500);
        }
    }

    public function delete_comment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:tbl_comment,comment_id',
        ]);

        try {
            $deleted = Comment::destroy($request->comment_id);
            if ($deleted === 0) {
                return $this->errorResponse('Không tìm thấy bình luận!', 404);
            }

            return $this->successResponse(null, 'Xóa bình luận thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi xóa bình luận ' . $e->getMessage(), 500);
        }
    }


    public function load_comment_user(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_product,product_id',
        ]);

        try {
            $comment = Comment::where('product_id', $request->product_id)->with('getUser')->orderBy('comment_id', 'desc')->paginate($this->linePerPageUser);
            return $this->successResponse($comment, 'Lấy tất cả bình luận thành công!', 200);

        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi lấy tất cả bình luận ' . $e->getMessage(), 500);
        }
    }

    public function add_comment_user(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_product,product_id',
            'comment_content' => 'required',
        ]);

        try {
            $comment = new Comment();
            $comment->comment_content = $request->comment_content;
            $comment->comment_reply = "";
            $comment->product_id = $request->product_id;
            $comment->user_id = Session::get('user_id');
            $comment->comment_status = 0;
            $comment->save();

            return $this->successResponse($comment, 'Thêm bình luận thành công!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra khi thêm cả bình luận ' . $e->getMessage(), 500);
        }
    }
}
