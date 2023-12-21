@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả bình luận
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-comment" aria-label="">
                    <option value="1" selected>Tất cả bình luận</option>
                    <option value="2">Đã trả lời</option>
                    <option value="3">Chưa trả lời</option>
                    <option value="4">Xóa đã chọn</option>
                    <option value="5">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-comment" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-comment" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-comment" type="text" class="form-control">
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
                        <th class="col-6">Bình luận</th>
                        <th class="col-2">Người bình luận</th>
                        <th class="text-center">Thời gian</th>
                        <th class="text-center">Nơi bình luận</th>
                        <th style="width:10px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-comment">

                </tbody>
            </table>
        </div>
    </div>
    <div class=" card-footer d-flex justify-content-end">
        <div class="pagination">
        </div>
    </div>
</div>

@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Bình luận";
        get_comment();

        $(document).on('click', '.btn-edit-comment', function() {
            let comment_id = $(this).parent().parent().parent().parent().data('comment-id');
            let comment_reply = $(`#comment-${comment_id}`).next().text();

            $(`#comment-${comment_id}`).empty();
            $(`#comment-${comment_id}`).next().empty();
            $(this).addClass('d-none');
            $(`#comment-${comment_id}`).append(
                `<form>
                    <textarea id="reply-comment-${comment_id}" row="3" class="form-control mb-1" required>${comment_reply}</textarea>
                    <div class="invalid-feedback mb-1">
                        Vui lòng nhập câu trả lời!
                    </div>
                    <button class="btn btn-success btn-sm btn-reply-comment-admin" data-comment-id="${comment_id}">Cập nhật</button>
                    <button class="btn btn-danger btn-sm btn-cancel-edit-comment">Hủy</button>
                </form>
            `)
        });

        $(document).on('click', '.btn-cancel-edit-comment', function(e) {
            e.preventDefault();
            let comment_id = $(this).parent().parent().parent().parent().data('comment-id');
            let comment_reply = $(`#reply-comment-${comment_id}`).val();

            $('.btn-edit-comment').removeClass('d-none');
            $(`#comment-${comment_id}`).empty();
            $(`#comment-${comment_id}`).next().empty();
            $(`#comment-${comment_id}`).append(
                `<span id="comment-${comment_id}" class="text-success">Trả lời: </span>`
            );
            $(`#comment-${comment_id}`).next().append(`<span>${comment_reply}</span>`);
        })

        $(document).on('click', '.btn-reply-comment-admin', function(e) {
            e.preventDefault();
            let comment_id = $(this).data('comment-id');
            let comment_reply = $(`#reply-comment-${comment_id}`).val();
            if (comment_reply) {
                $(`#reply-comment-${comment_id}`).removeClass('is-invalid');
                reply_comment(comment_reply, comment_id);
            } else {
                $(`#reply-comment-${comment_id}`).addClass('is-invalid');
            }
        });

        $(document).on('click', '.btn-delete-comment', function() {
            let comment_id = $(this).parent().parent().parent().parent().data('comment-id');
            show_modal_confirm_delete('Bạn muốn xóa bình luận này', 'data-comment-id', comment_id);
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let comment_id = $(this).attr('data-comment-id');
                delete_comment(comment_id);
            } else if (data_class == 'multi') {
                let comment_ids = $(this).attr('data-comment-id').split(',');
                $.each(comment_ids, function(key, value) {
                    delete_comment(value);
                });
            }
        })

        $(document).on('change', '.select-filter-comment', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 5) {
                $('.btn-filter-comment').addClass('d-none');
            } else {
                $('.btn-filter-comment').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_comment();
                    break;
                case '2':
                    get_comment(url = "{{URL::to('/admin/get-all-comment-by-status/1')}}",
                        select_value =
                        select);
                    break;
                case '3':
                    get_comment(url = "{{URL::to('/admin/get-all-comment-by-status/0')}}",
                        select_value =
                        select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-comment').click(function() {
            let select = $('.select-filter-comment').val();
            let comment_ids = [];
            $('#tbody-comment > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let comment_id = $(this).data('comment-id');
                    if (select == 4) {
                        comment_ids.push(comment_id);
                    }
                }
            });
            if (comment_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả bình luận này?', 'data-comment-id', comment_ids,
                    'multi');
            }
        })

        $('#form-search-comment').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-comment').val();
            if (keyword) {
                get_comment(url = `{{URL::to('/admin/search-comment/${keyword}')}}`, select_value = 5,
                    search_keyword = keyword);
            } else {
                get_comment();
            }
        });

        $('#keyword-search-comment').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_comment();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-comment').val();
            let select_value = $('.select-filter-comment').val();
            get_comment(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            console.log(data);
            $('#tbody-comment').empty();
            $.each(data, function(key, value) {
                $('#tbody-comment').append(
                    `<tr data-comment-id="${value.comment_id}">
                        <td>
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td class="text-center">${key + 1}</td>
                        <td>
                            <p class="mb-1">
                                <span class="text-primary">Bình luận:</span> ${value.comment_content}
                            </p>
                            ${value.comment_reply?
                                `<span id="comment-${value.comment_id}" class="text-success">Trả lời: </span>
                                <span>${value.comment_reply}</span>`:
                                `<form>
                                    <textarea id="reply-comment-${value.comment_id}" row="3" class="form-control mb-1" required></textarea>
                                    <div class="invalid-feedback mb-1">
                                        Vui lòng nhập câu trả lời!
                                    </div>
                                    <button class="btn btn-success btn-sm btn-reply-comment-admin" data-comment-id="${value.comment_id}">Trả lời</button>
                                </form>
                            `}
                        </td>
                        <td>${value.user_id}</td>
                        <td class="text-center">
                            ${formattedTime(value.comment_created_at)}
                        </td>
                        <td class="text-center">
                          <a href="{{URL::to('/chi-tiet-san-pham/${value.get_product.product_slug}')}}" class="btn btn-primary btn-sm">Đi đến</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-end">
                                ${value.comment_reply?` <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-comment"></i>
                                </a>`:''}
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-comment"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_comment(url = "{{URL::to('/admin/get-all-comment')}}", select_value = 1, search_keyword =
            '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-comment').val(search_keyword);
                        $('.select-filter-comment').val(select_value);
                        load_data_table(data.data.data);
                        set_pagination(data.data);
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data.message,
                            'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function reply_comment(comment_reply, comment_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/reply-comment')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    comment_reply,
                    comment_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-comment').val();
                        let search_keyword = $('#keyword-search-comment').val();
                        get_comment(url, select_value, search_keyword);
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data.message,
                            'danger');
                    }
                }
            })
        }

        function delete_comment(comment_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-comment')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    comment_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_comment();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data.message,
                            'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    })
</script>
@endsection