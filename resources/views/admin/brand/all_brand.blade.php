@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả thương hiệu
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-brand">
                    Thêm thương hiệu
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-brand" aria-label="">
                    <option value="1" selected>Tất cả thương hiệu</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-brand" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-brand" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-brand" type="text" class="form-control">
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
                        <th>Tên thương hiệu</th>
                        <th>Slug</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-brand">

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
<div class="modal fade modal-lg" id="modal-brand" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-brand" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-brand"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="brand_id" class="form-control" value="" id="brand_id">
                    <div class="form-group">
                        <label for="brand_name">Tên thương hiệu</label>
                        <input type="text" name="brand_name" class="form-control" value="" id="brand_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên thương hiệu!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="brand_slug">Slug</label>
                        <input type="text" name="brand_slug" class="form-control" value="" id="brand_slug" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập slug!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="brand_status">Trạng thái</label>
                        <select name="brand_status" class="form-control form-select" id="brand_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-brand"></button>
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
        document.title = "Admin - Thương hiệu";
        get_brand();
        convert_to_slug("#brand_name", "#brand_slug");

        $('.btn-add-brand').click(function() {
            $('#modal-title-brand').text('Thêm thương hiệu');
            set_brand_data({}, false);
            $('#brand_status').val('1');
            $('#btn-submit-brand').show();
            $('#btn-submit-brand').text('Thêm');
            $('#modal-brand').modal('show');
        });

        $(document).on('click', '.btn-detail-brand', function() {
            let brand_id = $(this).parent().parent().parent().parent().data('brand-id');
            get_brand_by_id(brand_id).then(function(result) {
                set_brand_data(result, true);
                $('#modal-title-brand').text('Thông tin thương hiệu');
                $('#btn-submit-brand').hide();
                $('#modal-brand').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-edit-brand', function() {
            let brand_id = $(this).parent().parent().parent().parent().data('brand-id');
            get_brand_by_id(brand_id).then(function(result) {
                set_brand_data(result, false);
                $('#modal-title-brand').text('Cập nhật thương hiệu');
                $('#btn-submit-brand').show();
                $('#btn-submit-brand').text('Cập nhật');
                $('#modal-brand').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-delete-brand', function() {
            let brand_id = $(this).parent().parent().parent().parent().data('brand-id');
            show_modal_confirm_delete('Bạn muốn xóa thương hiệu này', 'data-brand-id', brand_id);
        });

        $(document).on('click', '.btn-active-brand', function() {
            let brand_id = $(this).parent().parent().data('brand-id');
            change_status_brand(brand_id, 'active-brand');
        });

        $(document).on('click', '.btn-unactive-brand', function() {
            let brand_id = $(this).parent().parent().data('brand-id');
            change_status_brand(brand_id, 'unactive-brand');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let brand_id = $(this).attr('data-brand-id');
                delete_brand(brand_id);
            } else if (data_class == 'multi') {
                let brand_ids = $(this).attr('data-brand-id').split(',');
                $.each(brand_ids, function(key, value) {
                    delete_brand(value);
                });
            }
        })

        $(document).on('change', '.select-filter-brand', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 7) {
                $('.btn-filter-brand').addClass('d-none');
            } else {
                $('.btn-filter-brand').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_brand();
                    break;
                case '2':
                    get_brand(url = "{{URL::to('/admin/get-all-brand-by-status/1')}}", select_value =
                        select);
                    break;
                case '3':
                    get_brand(url = "{{URL::to('/admin/get-all-brand-by-status/0')}}", select_value =
                        select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-brand').click(function() {
            let select = $('.select-filter-brand').val();
            let brand_ids = [];
            $('#tbody-brand > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let brand_id = $(this).data('brand-id');
                    switch (select) {
                        case '4':
                            change_status_brand(brand_id, 'active-brand');
                            break;
                        case '5':
                            change_status_brand(brand_id, 'unactive-brand');
                            break;
                        case '6':
                            brand_ids.push(brand_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (brand_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả thương hiệu này?', 'data-brand-id', brand_ids,
                    'multi');
            }
        })

        $("#form-brand").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let brand_id = $('#brand_id').val();
                let brand_name = $('#brand_name').val();
                let brand_slug = $('#brand_slug').val();
                let brand_status = $('#brand_status').val();

                if (brand_id) {
                    update_brand(brand_id, brand_name, brand_slug, brand_status);
                } else {
                    add_brand(brand_name, brand_slug, brand_status);
                }
            }
        });

        $('#form-search-brand').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-brand').val();
            if (keyword) {
                get_brand(url = `{{URL::to('/admin/search-brand/${keyword}')}}`, select_value = 7,
                    search_keyword = keyword);
            } else {
                get_brand();
            }
        });

        $('#keyword-search-brand').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_brand();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-brand').val();
            let select_value = $('.select-filter-brand').val();
            get_brand(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-brand').empty();
            $.each(data, function(key, value) {
                $('#tbody-brand').append(
                    `<tr data-brand-id="${value.brand_id}">>
                        <td>
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td class="text-center">${key + 1}</td>
                        <td>${value.brand_name}</td>
                        <td>${value.brand_slug}</td>
                        <td class="text-center">
                            ${value.brand_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-brand">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-brand">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-brand"></i>
                                </a>
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-brand"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-brand"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_brand(url = "{{URL::to('/admin/get-all-brand')}}", select_value = 1, search_keyword = '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-brand').val(search_keyword);
                        $('.select-filter-brand').val(select_value);
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

        function get_brand_by_id(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-brand-by-id/${id}')}}`,
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

        function add_brand(brand_name, brand_slug, brand_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-brand')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    brand_name,
                    brand_slug,
                    brand_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        set_brand_data({}, false);
                        $('#brand_status').val('1');
                        get_brand();
                        $('#brand_slug').removeClass('is-invalid');
                        $('#brand_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.brand_slug) {
                        $('#form-brand').removeClass('was-validated');
                        $('#brand_slug').addClass('is-invalid');
                        $('#brand_slug').next().text(data.responseJSON.errors
                            .brand_slug[0]);
                    }
                }
            })
        }

        function update_brand(brand_id, brand_name, brand_slug, brand_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/edit-brand')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    brand_id,
                    brand_name,
                    brand_slug,
                    brand_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#modal-brand').modal('hide');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-brand').val();
                        let search_keyword = $('#keyword-search-brand').val();
                        get_brand(url, select_value, search_keyword);
                        $('#brand_slug').removeClass('is-invalid');
                        $('#brand_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.brand_slug) {
                        $('#form-brand').removeClass('was-validated');
                        $('#brand_slug').addClass('is-invalid');
                        $('#brand_slug').next().text(data.responseJSON.errors
                            .brand_slug[0]);
                    }
                }
            })
        }

        function delete_brand(brand_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-brand')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    brand_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_brand();
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

        function change_status_brand(brand_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${brand_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-brand').val();
                        let search_keyword = $('#keyword-search-brand').val();
                        get_brand(url, select_value, search_keyword);
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

        function set_brand_data(data, status) {
            $('#form-brand').removeClass('was-validated');

            $('#brand_id').val(data.brand_id);
            $('#brand_name').val(data.brand_name);
            $('#brand_slug').val(data.brand_slug);
            $('#brand_status').val(data.brand_status);

            $('#brand_name').prop('disabled', status);
            $('#brand_slug').prop('disabled', status);
            $('#brand_status').prop('disabled', status);
        }
    })
</script>
@endsection