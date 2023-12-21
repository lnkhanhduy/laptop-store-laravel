@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả danh mục sản phẩm
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-category-product">
                    Thêm danh mục
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-category-product" aria-label="">
                    <option value="1" selected>Tất cả danh mục</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-category-product" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-category-product" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-category-product" type="text"
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
                        <th>Thuộc danh mục</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-category-product">

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
<div class="modal fade modal-lg" id="modal-category-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-category-product" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-category-product"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="category_product_id" class="form-control" value=""
                        id="category_product_id">
                    <div class="form-group">
                        <label for="category_product_name">Tên danh mục</label>
                        <input type="text" name="category_product_name" class="form-control" value=""
                            id="category_product_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên danh mục!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_product_slug">Slug</label>
                        <input type="text" name="category_product_slug" class="form-control" value=""
                            id="category_product_slug" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập slug!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_product_parent">Danh mục cha</label>
                        <select name="category_product_parent" class="form-control form-select"
                            id="category_product_parent">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_product_status">Trạng thái</label>
                        <select name="category_product_status" class="form-control form-select"
                            id="category_product_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-category-product"></button>
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
        document.title = "Admin - Danh mục sản phẩm";
        get_category_product();
        load_category_product();
        convert_to_slug("#category_product_name", "#category_product_slug");

        $('.btn-add-category-product').click(function() {
            $('#modal-title-category-product').text('Thêm danh mục');

            set_category_product_data({}, false);
            $('#category_product_status').val('1');
            $('#btn-submit-category-product').show();
            $('#category_product_parent').val(0);
            $('#btn-submit-category-product').text('Thêm');

            $('#modal-category-product').modal('show');
        });

        $(document).on('click', '.btn-detail-category-product', function() {
            let category_product_id = $(this).parent().parent().parent().parent().data(
                'category-product-id');

            get_category_product_by_id(category_product_id).then(function(result) {
                set_category_product_data(result, true);
                $('#modal-title-category-product').text('Thông tin danh mục');
                $('#btn-submit-category-product').hide();
                $('#modal-category-product').modal('show');
            }).catch(function(error) {
                console.error(error);
            });

        });

        $(document).on('click', '.btn-edit-category-product', function() {
            let category_product_id = $(this).parent().parent().parent().parent().data(
                'category-product-id');

            load_category_product(category_product_id);
            get_category_product_by_id(category_product_id)
                .then(function(resultGet) {
                    set_category_product_data(resultGet, false);
                    $('#modal-title-category-product').text('Cập nhật danh mục');
                    $('#btn-submit-category-product').show();
                    $('#btn-submit-category-product').text('Cập nhật');
                    $('#modal-category-product').modal('show');
                }).catch(function(error) {
                    console.error(error);
                });
        });

        $(document).on('click', '.btn-delete-category-product', function() {
            let category_product_id = $(this).parent().parent().parent().parent().data(
                'category-product-id');
            show_modal_confirm_delete('Bạn muốn xóa danh mục này', 'data-category-product-id',
                category_product_id);
        });

        $(document).on('click', '.btn-active-category-product', function() {
            let category_product_id = $(this).parent().parent().data('category-product-id');
            change_status_category_product(category_product_id, 'active-category-product');
        });

        $(document).on('click', '.btn-unactive-category-product', function() {
            let category_product_id = $(this).parent().parent().data('category-product-id');
            change_status_category_product(category_product_id, 'unactive-category-product');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let category_product_id = $(this).attr('data-category-product-id');
                delete_category_product(category_product_id);
            } else if (data_class == 'multi') {
                let category_product_ids = $(this).attr('data-category-product-id').split(',');
                $.each(category_product_ids, function(key, value) {
                    delete_category_product(value);
                });
            }

        })

        $(document).on('change', '.select-filter-category-product', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 7) {
                $('.btn-filter-category-product').addClass('d-none');
            } else {
                $('.btn-filter-category-product').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_category_product();
                    break;
                case '2':
                    get_category_product(url =
                        "{{URL::to('/admin/get-all-category-product-by-status/1')}}",
                        select_value = select);
                    break;
                case '3':
                    get_category_product(url =
                        "{{URL::to('/admin/get-all-category-product-by-status/0')}}",
                        select_value = select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-category-product').click(function() {
            let select = $('.select-filter-category-product').val();
            let category_product_ids = [];
            $('#tbody-category-product > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let category_product_id = $(this).data('category-product-id');
                    switch (select) {
                        case '4':
                            change_status_category_product(category_product_id,
                                'active-category-product');
                            break;
                        case '5':
                            change_status_category_product(category_product_id,
                                'unactive-category-product');
                            break;
                        case '6':
                            category_product_ids.push(category_product_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (category_product_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả danh mục này?', 'data-category-product-id',
                    category_product_ids,
                    'multi');
            }
        })

        $("#form-category-product").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let category_product_id = $('#category_product_id').val();
                let category_product_name = $('#category_product_name').val();
                let category_product_slug = $('#category_product_slug').val();
                let category_product_parent = $('#category_product_parent').val();
                let category_product_status = $('#category_product_status').val();

                if (category_product_id) {
                    update_category_product(category_product_id, category_product_name,
                        category_product_slug, category_product_parent,
                        category_product_status);
                } else {
                    add_category_product(category_product_name, category_product_slug,
                        category_product_parent,
                        category_product_status);
                }
            }
        });

        $('#form-search-category-product').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-category-product').val();
            if (keyword) {
                get_category_product(url = `{{URL::to('/admin/search-category-product/${keyword}')}}`,
                    select_value = 7,
                    search_keyword = keyword);
            } else {
                get_category_product();
            }
        });

        $('#keyword-search-category-product').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_category_product();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-category-product').val();
            let select_value = $('.select-filter-category-product').val();
            get_category_product(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-category-product').empty();

            $.each(data.data, function(key, value) {
                $('#tbody-category-product').append(
                    `<tr data-category-product-id="${value.category_product_id}">>
                            <td>
                                <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                            </td>
                            <td class="text-center">${key + 1}</td>
                            <td>${value.category_product_name}</td>
                            <td>${value.category_product_slug}</td>
                            <td>${value.category_product_parent==0?'<span class="text-danger fw-bold"><b>Danh mục cha</b></span>':'<span class="text-success fw-bold">'+value.parent_name+'</span>'
                            }</td>
                        <td class="text-center">
                            ${value.category_product_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-category-product">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-category-product">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-category-product"></i>
                                </a>
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-category-product"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-category-product"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_category_product(url = "{{URL::to('/admin/get-all-category-product')}}", select_value = 1,
            search_keyword = '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-category-product').val(search_keyword);
                        $('.select-filter-category-product').val(select_value);
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

        function get_category_product_by_id(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-category-product-by-id/${id}')}}`,
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

        function add_category_product(category_product_name, category_product_slug, category_product_parent,
            category_product_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-category-product')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_product_name,
                    category_product_slug,
                    category_product_parent,
                    category_product_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        set_category_product_data({}, false);
                        $('#category_product_status').val('1');
                        get_category_product();
                        load_category_product();
                        $('#category_product_slug').removeClass('is-invalid');
                        $('#category_product_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.category_product_slug) {
                        $('#form-category-product').removeClass('was-validated');
                        $('#category_product_slug').addClass('is-invalid');
                        $('#category_product_slug').next().text(data.responseJSON.errors
                            .category_product_slug[0]);
                    }
                }
            })
        }

        function update_category_product(category_product_id, category_product_name, category_product_slug,
            category_product_parent, category_product_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/edit-category-product')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_product_id,
                    category_product_name,
                    category_product_slug,
                    category_product_parent,
                    category_product_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#modal-category-product').modal('hide');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-category-product').val();
                        let search_keyword = $('#keyword-search-category-product').val();
                        get_category_product(url, select_value, search_keyword);
                        $('#category_product_slug').removeClass('is-invalid');
                        $('#category_product_slug').next().text('Vui lòng nhập slug!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.category_product_slug) {
                        $('#form-category-product').removeClass('was-validated');
                        $('#category_product_slug').addClass('is-invalid');
                        $('#category_product_slug').next().text(data.responseJSON.errors
                            .category_product_slug[0]);
                    }
                }
            })
        }

        function delete_category_product(category_product_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-category-product')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_product_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_category_product();
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

        function change_status_category_product(category_product_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${category_product_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-category-product').val();
                        let search_keyword = $('#keyword-search-category-product').val();
                        get_category_product(url, select_value, search_keyword);
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

        function set_category_product_data(data, status) {
            $('#form-category-product').removeClass('was-validated');

            $('#category_product_id').val(data.category_product_id);
            $('#category_product_name').val(data.category_product_name);
            $('#category_product_slug').val(data.category_product_slug);
            $('#category_product_parent').val(data.category_product_parent);
            $('#category_product_status').val(data.category_product_status);

            $('#category_product_name').prop('disabled', status);
            $('#category_product_slug').prop('disabled', status);
            $('#category_product_parent').prop('disabled', status);
            $('#category_product_status').prop('disabled', status);
        }

        function load_category_product(id = -1) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-all-category-product')}}`,
                    success: function(data) {
                        if (data.status == 200) {

                            $('#category_product_parent').empty();
                            $('#category_product_parent').append(
                                `<option value="0">Không</option>`);

                            $('#category_product_parent').append(
                                data.data.map((item) => {
                                    if (id != -1) {
                                        if (item.category_product_id != id) {
                                            return `<option value="${item.category_product_id}">${item.category_product_name}</option>`;
                                        } else {
                                            return '';
                                        }
                                    } else {
                                        return `<option value="${item.category_product_id}">${item.category_product_name}</option>`;
                                    }
                                }).join('')
                            );
                        } else {
                            reject("Error");
                        }
                    },
                    error: function(data) {
                        reject("Error");
                    }
                })
            })
        }
    })
</script>
@endsection