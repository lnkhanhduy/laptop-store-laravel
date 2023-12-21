@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Thêm bài viết
    </div>
    <div class="card-body h-75 overflow-auto">
        <form class="needs-validation" id="form-post" novalidate enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="post_title">Tiêu đề bài viết</label>
                        <input type="text" name="post_title" class="form-control" value="" id="post_title" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tiêu đề bài viết!
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="post_slug">Slug</label>
                        <input type="text" name="post_slug" class="form-control" value="" id="post_slug" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập slug!
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Hình ảnh bài viết</label>
                    <input type="file" name="post_image" class="form-control" id="post_image" placeholder=""
                        accept="image/*" required>
                    <div class="invalid-feedback">
                        Vui lòng chọn hình ảnh!
                    </div>
                </div>

                <div class="form-group">
                    <label for="post_desc">Mô tả ngắn</label>
                    <textarea style="resize:none" rows="3" name="post_desc" class="form-control" id="post_desc"
                        required></textarea>
                    <div class="invalid-feedback">
                        Vui lòng nhập mô tả bài viết!
                    </div>
                </div>
                <div class="form-group">
                    <label for="post_content">Nội dung bài viết</label>
                    <textarea style="resize:none" rows="5" name="post_content" class="form-control" id="post_content"
                        required></textarea>
                    <div class="invalid-feedback">
                        Vui lòng nhập nội dung bài viết!
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-8">
                        <label for="category_post_id">Danh mục</label>
                        <select name="category_post_id" class="form-control form-select" id="category_post_id">
                            @foreach ($category_post as $item)
                            <option value="{{$item->category_post_id}}">
                                {{$item->category_post_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <label for="post_status">Trạng thái</label>
                        <select name="post_status" class="form-control form-select" id="post_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{URL::to('/admin/post')}}">Quay lại</a>
                <button type="submit" class="btn btn-success ms-1">Thêm</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-add-post" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header row">
                <div class="text-center text-success" style="font-size: 70px">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <h2 class="modal-title fs-4 text-center mt-2">
                    Thêm bài viết thành công
                </h2>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{URL::to('/post')}}" class="btn btn-secondary">Xem tất cả bài viết</a>
                <button type="button" class="btn btn-primary btn-continue-add-post" data-dismiss="modal">Tiếp tục thêm
                    bài viết</button>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->
@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Thêm bài viết";
        CKEDITOR.replace('post_content');

        convert_to_slug("#post_title", "#post_slug");

        $('#form-post').on('submit', function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                add_post();
            }
        });

        $(document).on('click', '.btn-continue-add-post', function(e) {
            $("#modal-add-post").modal('hide');
        })

        function add_post() {
            let form_data = new FormData();
            form_data.append('post_title', $('#post_title').val());
            form_data.append('post_slug', $('#post_slug').val());
            form_data.append('post_image', $('#post_image')[0].files[0]);
            form_data.append('post_desc', $('#post_desc').val());
            form_data.append('post_content', $('#post_content').val());
            form_data.append('category_post_id', $('#category_post_id').val());
            form_data.append('post_status', $('#post_status').val());
            console.log(form_data.get('post_image'));
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-post')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == 200) {
                        $("#modal-add-post").modal('show');
                        $('#form-post').removeClass('was-validated');
                        $('#post_title').val('');
                        $('#post_slug').val('');
                        $('#post_image').val('');
                        $('#post_desc').val('');
                        $('#post_content').val('');
                        $('#post_status').val('1');
                        $('#post_slug').removeClass('is-invalid');
                        $('#post_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-exclamation me-2"></i>', data
                            .message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.post_slug) {
                        $('#form-post').removeClass('was-validated');
                        $('#post_slug').addClass('is-invalid');
                        $('#post_slug').next().text(data.responseJSON.errors
                            .post_slug[0]);
                    }
                }
            })
        }
    });
</script>
@endsection