@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả danh mục bài viết
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-category-post">
                    Thêm danh mục
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-category-post" aria-label="">
                    <option value="1" selected>Tất cả danh mục</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-category-post" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-category-post" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-category-post" type="text"
                        class="form-control">
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
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-category-post">

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <div class="pagination">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="modal-category-post" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-category-post" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-category-post"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="category_post_id" class="form-control" value="" id="category_post_id">
                    <div class="form-group">
                        <label for="category_post_name">Tên danh mục</label>
                        <input type="text" name="category_post_name" class="form-control" value=""
                            id="category_post_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên danh mục!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_post_slug">Slug</label>
                        <input type="text" name="category_post_slug" class="form-control" value=""
                            id="category_post_slug" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập slug!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_post_status">Trạng thái</label>
                        <select name="category_post_status" class="form-control form-select" id="category_post_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-category-post"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal -->

@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Danh mục bài viết";
        get_category_post();
        convert_to_slug("#category_post_name", "#category_post_slug");

        $('.btn-add-category-post').click(function() {
            $('#modal-title-category-post').text('Thêm danh mục');

            set_category_post_data({}, false);
            $('#category_post_status').val('1');
            $('#btn-submit-category-post').show();
            $('#btn-submit-category-post').text('Thêm');

            $('#modal-category-post').modal('show');
        });

        $(document).on('click', '.btn-detail-category-post', function() {
            let category_post_id = $(this).parent().parent().parent().parent().data(
                'category-post-id');

            get_category_post_by_id(category_post_id).then(function(result) {
                set_category_post_data(result, true);
                $('#modal-title-category-post').text('Thông tin danh mục');
                $('#btn-submit-category-post').hide();
                $('#modal-category-post').modal('show');
            }).catch(function(error) {
                console.error(error);
            });

        });

        $(document).on('click', '.btn-edit-category-post', function() {
            let category_post_id = $(this).parent().parent().parent().parent().data(
                'category-post-id');

            get_category_post_by_id(category_post_id)
                .then(function(resultGet) {
                    set_category_post_data(resultGet, false);
                    $('#modal-title-category-post').text('Cập nhật danh mục');
                    $('#btn-submit-category-post').show();
                    $('#btn-submit-category-post').text('Cập nhật');
                    $('#modal-category-post').modal('show');
                }).catch(function(error) {
                    console.error(error);
                });
        });

        $(document).on('click', '.btn-delete-category-post', function() {
            let category_post_id = $(this).parent().parent().parent().parent().data(
                'category-post-id');
            show_modal_confirm_delete('Bạn muốn xóa danh mục này', 'data-category-post-id',
                category_post_id);
        });

        $(document).on('click', '.btn-active-category-post', function() {
            let category_post_id = $(this).parent().parent().data('category-post-id');
            change_status_category_post(category_post_id, 'active-category-post');
        });

        $(document).on('click', '.btn-unactive-category-post', function() {
            let category_post_id = $(this).parent().parent().data('category-post-id');
            change_status_category_post(category_post_id, 'unactive-category-post');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let category_post_id = $(this).attr('data-category-post-id');
                delete_category_post(category_post_id);
            } else if (data_class == 'multi') {
                let category_post_ids = $(this).attr('data-category-post-id').split(',');
                $.each(category_post_ids, function(key, value) {
                    delete_category_post(value);
                });
            }
        })

        $(document).on('change', '.select-filter-category-post', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 7) {
                $('.btn-filter-category-post').addClass('d-none');
            } else {
                $('.btn-filter-category-post').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_category_post();
                    break;
                case '2':
                    get_category_post(url = "{{URL::to('/admin/get-all-category-post-by-status/1')}}",
                        select_value = select);
                    break;
                case '3':
                    get_category_post(url = "{{URL::to('/admin/get-all-category-post-by-status/0')}}",
                        select_value = select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-category-post').click(function() {
            let select = $('.select-filter-category-post').val();
            let category_post_ids = [];
            $('#tbody-category-post > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let category_post_id = $(this).data('category-post-id');
                    switch (select) {
                        case '4':
                            change_status_category_post(category_post_id,
                                'active-category-post');
                            break;
                        case '5':
                            change_status_category_post(category_post_id,
                                'unactive-category-post');
                            break;
                        case '6':
                            category_post_ids.push(category_post_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (category_post_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả danh mục này?', 'data-category-post-id',
                    category_post_ids,
                    'multi');
            }
        })

        $("#form-category-post").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let category_post_id = $('#category_post_id').val();
                let category_post_name = $('#category_post_name').val();
                let category_post_slug = $('#category_post_slug').val();
                let category_post_status = $('#category_post_status').val();

                if (category_post_id) {
                    update_category_post(category_post_id, category_post_name,
                        category_post_slug, category_post_status);
                } else {
                    add_category_post(category_post_name, category_post_slug, category_post_status);
                }
            }
        });

        $('#form-search-category-post').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-category-post').val();
            if (keyword) {
                get_category_post(url = `{{URL::to('/admin/search-category-post/${keyword}')}}`,
                    select_value = 7,
                    search_keyword = keyword);
            } else {
                get_category_post();
            }
        });

        $('#keyword-search-category-post').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_category_post();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-category-post').val();
            let select_value = $('.select-filter-category-post').val();
            get_category_post(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-category-post').empty();

            $.each(data.data, function(key, value) {
                $('#tbody-category-post').append(
                    `<tr data-category-post-id="${value.category_post_id}">>
                            <td>
                                <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                            </td>
                            <td class="text-center">${key + 1}</td>
                            <td>${value.category_post_name}</td>
                            <td>${value.category_post_slug}</td>
                            <td class="text-center">
                            ${value.category_post_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-category-post">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-category-post">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-category-post"></i>
                                </a>
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-category-post"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-category-post"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_category_post(url = "{{URL::to('/admin/get-all-category-post')}}", select_value = 1,
            search_keyword = '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-category-post').val(search_keyword);
                        $('.select-filter-category-post').val(select_value);
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

        function get_category_post_by_id(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-category-post-by-id/${id}')}}`,
                    success: function(data) {
                        if (data.status == 200) {
                            resolve(data.data);
                        } else {
                            resolve(data.message);
                        }
                    },
                    error: function(data) {
                        reject("Error");
                    }
                });
            });
        }

        function add_category_post(category_post_name, category_post_slug, category_post_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-category-post')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_post_name,
                    category_post_slug,
                    category_post_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        set_category_post_data({}, false);
                        $('#category_post_status').val('1');
                        get_category_post();
                        $('#category_post_slug').removeClass('is-invalid');
                        $('#category_post_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.category_post_slug) {
                        $('#form-category-post').removeClass('was-validated');
                        $('#category_post_slug').addClass('is-invalid');
                        $('#category_post_slug').next().text(data.responseJSON.errors
                            .category_post_slug[0]);
                    }
                }
            })
        }

        function update_category_post(category_post_id, category_post_name, category_post_slug,
            category_post_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/edit-category-post')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_post_id,
                    category_post_name,
                    category_post_slug,
                    category_post_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#modal-category-post').modal('hide');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-category-post').val();
                        let search_keyword = $('#keyword-search-category-post').val();
                        get_category_post(url, select_value, search_keyword);
                        $('#category_post_slug').removeClass('is-invalid');
                        $('#category_post_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.category_post_slug) {
                        $('#form-category-post').removeClass('was-validated');
                        $('#category_post_slug').addClass('is-invalid');
                        $('#category_post_slug').next().text(data.responseJSON.errors
                            .category_post_slug[0]);
                    }
                }
            })
        }

        function delete_category_post(category_post_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-category-post')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_post_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_category_post();
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

        function change_status_category_post(category_post_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${category_post_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-category-post').val();
                        let search_keyword = $('#keyword-search-category-post').val();
                        get_category_post(url, select_value, search_keyword);
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

        function set_category_post_data(data, status) {
            $('#form-category-post').removeClass('was-validated');

            $('#category_post_id').val(data.category_post_id);
            $('#category_post_name').val(data.category_post_name);
            $('#category_post_slug').val(data.category_post_slug);
            $('#category_post_status').val(data.category_post_status);

            $('#category_post_name').prop('disabled', status);
            $('#category_post_slug').prop('disabled', status);
            $('#category_post_status').prop('disabled', status);
        }
    })
</script>
@endsection