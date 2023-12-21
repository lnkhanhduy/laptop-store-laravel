@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả bài viết
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <a href="{{URL::to('/admin/add-post')}}" type="button" class="btn btn-success">
                    Thêm bài viết
                </a>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-post" aria-label="">
                    <option value="1" selected>Tất cả bài viết</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-post" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-post" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-post" type="text" class="form-control">
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light table-hover">
                <thead>
                    <tr>
                        <th style="width:20px;"></th>
                        <th class="text-center">#</th>
                        <th>Tiêu đề bài viết</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-post">

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <div class="pagination">
        </div>
    </div>
</div>
@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Bài viết";
        get_post();

        $(document).on('click', '.btn-delete-post', function() {
            let post_id = $(this).parent().parent().parent().parent().data('post-id');
            show_modal_confirm_delete('Bạn muốn xóa bài viết này', 'data-post-id',
                post_id);
        });

        $(document).on('click', '.btn-active-post', function() {
            let post_id = $(this).parent().parent().data('post-id');
            change_status_post(post_id, 'active-post');
        });

        $(document).on('click', '.btn-unactive-post', function() {
            let post_id = $(this).parent().parent().data('post-id');
            change_status_post(post_id, 'unactive-post');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let post_id = $(this).attr('data-post-id');
                delete_post(post_id);
            } else if (data_class == 'multi') {
                let post_ids = $(this).attr('data-post-id').split(',');
                $.each(post_ids, function(key, value) {
                    delete_post(value);
                });
            }

        })

        $(document).on('change', '.select-filter-post', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 7) {
                $('.btn-filter-post').addClass('d-none');
            } else {
                $('.btn-filter-post').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_post();
                    break;
                case '2':
                    get_post(url = "{{URL::to('/admin/get-all-post-by-status/1')}}",
                        select_value = select);
                    break;
                case '3':
                    get_post(url = "{{URL::to('/admin/get-all-post-by-status/0')}}",
                        select_value = select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-post').click(function() {
            let select = $('.select-filter-post').val();
            let post_ids = [];
            $('#tbody-post > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let post_id = $(this).data('post-id');
                    switch (select) {
                        case '4':
                            change_status_post(post_id,
                                'active-post');
                            break;
                        case '5':
                            change_status_post(post_id,
                                'unactive-post');
                            break;
                        case '6':
                            post_ids.push(post_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (post_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả bài viết này?', 'data-post-id',
                    post_ids,
                    'multi');
            }
        });

        $('#form-search-post').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-post').val();
            if (keyword) {
                get_post(url = `{{URL::to('/admin/search-post/${keyword}')}}`,
                    select_value = 7,
                    search_keyword = keyword);
            } else {
                get_post();
            }
        });

        $('#keyword-search-post').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_post();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-post').val();
            let select_value = $('.select-filter-post').val();
            get_post(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-post').empty();

            $.each(data.data, function(key, value) {
                $('#tbody-post').append(
                    `<tr data-post-id="${value.post_id}">
                        <td>
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td class="text-center">${key + 1}</td>
                        <td>${value.post_title}</td>
                        <td>
                            <img src="{{URL::to('/public/uploads/post/${value.post_image}')}}" alt="" width="100px" height="50px" class="object-fit-contain">
                        </td>
                        <td>${value.post_desc}</td>
                        <td class="text-center">
                            ${value.post_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-post">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-post">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" href="{{URL::to('/admin/view-post/${value.post_id}')}}">
                                    <i class="fa-solid fa-circle-info text-primary"></i>
                                </a>
                                <a class="me-2" href="{{URL::to('/admin/edit-post/${value.post_id}')}}">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-post"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-post"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_post(url = "{{URL::to('/admin/get-all-post')}}", select_value = 1,
            search_keyword = '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-post').val(search_keyword);
                        $('.select-filter-post').val(select_value);
                        load_data_table(data.data);
                        set_pagination(data.data);
                    } else {
                        console.log(data);
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data
                            .message,
                            'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function delete_post(post_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-post')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    post_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_post();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data
                            .message,
                            'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        function change_status_post(post_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${post_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-post').val();
                        let search_keyword = $('#keyword-search-post').val();
                        get_post(url, select_value, search_keyword);
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data
                            .message,
                            'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    });
</script>
@endsection