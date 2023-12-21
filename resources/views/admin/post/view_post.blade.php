@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    @foreach($post_item as $value_post)
    <div class="card-header position-relative">
        <span>Chi tiết bài viết</span>
        <div class="position-absolute" style="right:10px">
            <a class="btn btn-warning" href="{{URL::to('/admin/edit-post/'.$value_post->post_id)}}">Chỉnh sửa</a>
            <a class="btn btn-primary" href="{{URL::to('/admin/post')}}">Quay lại</a>
        </div>
    </div>
    <div class="card-body h-75">
        <div class="modal-body h-100 overflow-auto">
            <p class="card-text mb-2">Tiêu đề: {{$value_post->post_title}}</p>
            <p class="card-text mb-2">Slug: {{$value_post->post_slug}}</p>
            <p class="card-text mb-2">Danh mục: {{$value_post->getCategoryName->category_post_name}}</p>
            <p class="card-text mb-2">Mô tả: {{$value_post->post_desc}}</p>
            <p class="card-text mb-2">Lượt xem: {{$value_post->post_views}}</p>
            <p class="card-text mb-2">Trạng thái: {{$value_post->post_status==0?'Đang ẩn':'Hiển thị'}}</p>
            <p class="card-text mb-2">Nội dung:</p>
            <p>{!!$value_post->post_content!!}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('admin_script')
<script type="text/javascript">
    document.title = "Chi tiết bài viết";
</script>
@endsection