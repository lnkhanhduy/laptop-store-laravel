@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả sản phẩm
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-product">
                    Thêm sản phẩm
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-product" aria-label="">
                    <option value="1" selected>Tất cả sản phẩm</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-product" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-product" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-product" type="text" class="form-control">
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
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Thư viện ảnh</th>
                        <th>Giá bán</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-product">

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
<div class="modal fade modal-lg" id="modal-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-product" novalidate enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-product"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" class="form-control" value="" id="product_id">
                    <div class="form-group">
                        <label for="product_name">Tên sản phẩm</label>
                        <input type="text" name="product_name" class="form-control" value="" id="product_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên sản phẩm!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_slug">Slug</label>
                        <input type="text" name="product_slug" class="form-control" value="" id="product_slug" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập slug!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh sản phẩm</label>
                        <input type="file" name="product_image" class="form-control" id="product_image" placeholder=""
                            accept="image/*" required>
                        <div class="invalid-feedback">
                            Vui lòng chọn hình ảnh!
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product_desc">Mô tả</label>
                        <textarea style="resize:none" rows="3" name="product_desc" class="form-control"
                            id="product_desc" required></textarea>
                        <div class="invalid-feedback">
                            Vui lòng nhập mô tả sản phẩm!
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="product_parent">Thương hiệu</label>
                            <select name="brand_id" class="form-control form-select" id="brand_id">
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="product_parent">Danh mục</label>
                            <select name="category_product_id" class="form-control form-select"
                                id="category_product_id">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="product_cost">Giá nhập</label>
                            <input type="text" name="product_cost" class="form-control" id="product_cost" placeholder=""
                                required>
                            <div class="invalid-feedback">
                                Vui lòng nhập giá nhập sản phẩm!
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="product_price">Giá bán</label>
                            <input type="text" name="product_price" class="form-control" id="product_price"
                                placeholder="" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập giá bán sản phẩm!
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="product_price_discount">Giá đã giảm (Nếu có)</label>
                            <input type="text" name="product_price_discount" class="form-control"
                                id="product_price_discount" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="product_quantity">Số lượng sản phẩm</label>
                            <input type="text" name="product_quantity" class="form-control" id="product_quantity"
                                placeholder="" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập số lượng sản phẩm!
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="product_sold">Đã bán</label>
                            <input type="text" name="product_sold" value="0" class="form-control" id="product_sold"
                                placeholder="0" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_status">Trạng thái</label>
                        <select name="product_status" class="form-control form-select" id="product_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-product"></button>
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
    document.title = "Admin - Sản phẩm";

    get_product();
    get_all_category_product();
    get_all_brand();
    convert_to_slug("#product_name", "#product_slug");

    $('.btn-add-product').click(function() {
        $('#modal-title-product').text('Thêm sản phẩm');

        set_product_data({}, false);
        $('#product_image').prop('required', true);
        $('#product_status').val('1');
        $('#btn-submit-product').show();
        $('#product_parent').val(0);
        $('#btn-submit-product').text('Thêm');

        $('#modal-product').modal('show');
    });

    $(document).on('click', '.btn-detail-product', function() {
        let product_id = $(this).parent().parent().parent().parent().data(
            'product-id');

        get_product_by_id(product_id).then(function(result) {
            set_product_data(result, true);
            $('#modal-title-product').text('Thông tin sản phẩm');
            $('#btn-submit-product').hide();
            $('#modal-product').modal('show');
        }).catch(function(error) {
            console.error(error);
        });

    });

    $(document).on('click', '.btn-edit-product', function() {
        let product_id = $(this).parent().parent().parent().parent().data(
            'product-id');

        get_product_by_id(product_id)
            .then(function(resultGet) {
                set_product_data(resultGet, false);
                $('#product_image').prop('required', false);
                $('#modal-title-product').text('Cập nhật sản phẩm');
                $('#btn-submit-product').show();
                $('#btn-submit-product').text('Cập nhật');
                $('#modal-product').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
    });

    $(document).on('click', '.btn-delete-product', function() {
        let product_id = $(this).parent().parent().parent().parent().data(
            'product-id');
        show_modal_confirm_delete('Bạn muốn xóa sản phẩm này', 'data-product-id',
            product_id);
    });

    $(document).on('click', '.btn-active-product', function() {
        let product_id = $(this).parent().parent().data('product-id');
        change_status_product(product_id, 'active-product');
    });

    $(document).on('click', '.btn-unactive-product', function() {
        let product_id = $(this).parent().parent().data('product-id');
        change_status_product(product_id, 'unactive-product');
    });

    $('#btn-submit-confirm-delete').click(function() {
        let data_class = $(this).attr('data-class');
        if (data_class == 'single') {
            let product_id = $(this).attr('data-product-id');
            delete_product(product_id);
        } else if (data_class == 'multi') {
            let product_ids = $(this).attr('data-product-id').split(',');
            $.each(product_ids, function(key, value) {
                delete_product(value);
            });
        }

    })

    $(document).on('change', '.select-filter-product', function() {
        let select = $(this).val();
        if (select == 1 || select == 2 || select == 3 || select == 7) {
            $('.btn-filter-product').addClass('d-none');
        } else {
            $('.btn-filter-product').removeClass('d-none');
        }

        switch (select) {
            case '1':
                get_product();
                break;
            case '2':
                get_product(url = "{{URL::to('/admin/get-all-product-by-status/1')}}",
                    select_value = select);
                break;
            case '3':
                get_product(url = "{{URL::to('/admin/get-all-product-by-status/0')}}",
                    select_value = select);
                break;
            default:
                break;
        }
    })

    $('.btn-filter-product').click(function() {
        let select = $('.select-filter-product').val();
        let product_ids = [];
        $('#tbody-product > tr').each(function(index, item) {
            if ($(this).find('input').is(':checked')) {
                let product_id = $(this).data('product-id');
                switch (select) {
                    case '4':
                        change_status_product(product_id,
                            'active-product');
                        break;
                    case '5':
                        change_status_product(product_id,
                            'unactive-product');
                        break;
                    case '6':
                        product_ids.push(product_id);
                        break;
                    default:
                        break;
                }
            }
        });
        if (product_ids.length > 0) {
            show_modal_confirm_delete(
                'Bạn có chắc muốn xóa tất cả sản phẩm này?', 'data-product-id',
                product_ids,
                'multi');
        }
    })

    $("#form-product").submit(function(e) {
        e.preventDefault();
        if (this.checkValidity() === false) {
            e.stopPropagation();
        } else {
            let product_id = $('#product_id').val();
            let product_name = $('#product_name').val();
            let product_slug = $('#product_slug').val();
            let category_product_id = $('#category_product_id').val();
            let brand_id = $('#brand_id').val();
            let product_quantity = $('#product_quantity').val();
            let product_desc = $('#product_desc').val();
            let product_cost = $('#product_cost').val();
            let product_price = $('#product_price').val();
            let product_price_discount = $('#product_price_discount').val();
            let product_image = $('#product_image')[0].files[0];
            let product_status = $('#product_status').val();

            if (product_id) {
                update_product(product_id, product_name, product_slug, category_product_id,
                    brand_id, product_quantity, product_desc, product_cost,
                    product_price, product_price_discount, product_image, product_status);
            } else {
                add_product(product_name, product_slug, category_product_id, brand_id,
                    product_quantity, product_desc, product_cost,
                    product_price, product_price_discount, product_image, product_status);
            }
        }
    });

    $('#form-search-product').submit(function(e) {
        e.preventDefault();
        let keyword = $('#keyword-search-product').val();
        if (keyword) {
            get_product(url = `{{URL::to('/admin/search-product/${keyword}')}}`,
                select_value = 7,
                search_keyword = keyword);
        } else {
            get_product();
        }
    });

    $('#keyword-search-product').keyup(function(e) {
        if ($(this).val().length == 0) {
            get_product();
        }
    })

    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let keyword = $('#keyword-search-product').val();
        let select_value = $('.select-filter-product').val();
        get_product(url, select_value = select_value, search_keyword =
            keyword);
    })

    function load_data_table(data) {
        $('#tbody-product').empty();

        $.each(data.data, function(key, value) {
            $('#tbody-product').append(
                `<tr data-product-id="${value.product_id}">>
                            <td>
                                <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                            </td>
                            <td class="text-center">${key + 1}</td>
                            <td>${value.product_name}</td>
                            <td>
                                <img src="{{URL::to('/public/uploads/product/${value.product_image}')}}" alt="" width="100px" height="50px" class="object-fit-contain">
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{URL::to('/admin/gallery-product/${value.product_slug}')}}">Xem thư viện</a>
                            </td>
                            <td>${value.product_price_discount!=0 ? format_currency(value.product_price_discount) : format_currency(value.product_price)}</td>
                        <td class="text-center">
                            ${value.product_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-product">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-product">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-product"></i>
                                </a>
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-product"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-product"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
            )
        })
    }

    function get_product(url = "{{URL::to('/admin/get-all-product')}}", select_value = 1,
        search_keyword = '') {
        $.ajax({
            type: "GET",
            url,
            data: {
                pagination: true
            },
            success: function(data) {
                if (data.status == 200) {
                    $('#keyword-search-product').val(search_keyword);
                    $('.select-filter-product').val(select_value);
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

    function get_product_by_id(id) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/get-product-by-id/${id}')}}`,
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

    function add_product(product_name, product_slug, category_product_id,
        brand_id, product_quantity, product_desc, product_cost, product_price,
        product_price_discount,
        product_image, product_status) {
        let form_data = new FormData();
        form_data.append('product_name', product_name);
        form_data.append('product_slug', product_slug);
        form_data.append('category_product_id', category_product_id);
        form_data.append('brand_id', brand_id);
        form_data.append('product_quantity', product_quantity);
        form_data.append('product_desc', product_desc);
        form_data.append('product_cost', product_cost);
        form_data.append('product_price', product_price);
        form_data.append('product_price_discount', product_price_discount);
        form_data.append('product_image', product_image);
        form_data.append('product_status', product_status);

        $.ajax({
            type: "POST",
            url: "{{URL::to('/admin/add-product')}}",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: form_data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data.status == 200) {
                    show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                        data.message, 'success');
                    set_product_data({}, false);
                    $('#product_status').val('1');
                    get_product();
                    $('#product_slug').removeClass('is-invalid');
                    $('#product_slug').next().text('Vui lòng nhập slug!');
                    $('#product_price').removeClass('is-invalid');
                    $('#product_price').next().text('Vui lòng nhập giá bán!');
                } else {
                    console.log(data);
                    show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                        data.message, 'danger');
                }
            },
            error: function(data) {
                if (data.status == 422) {
                    if (data.responseJSON.errors.product_slug) {
                        $('#form-product').removeClass('was-validated');
                        $('#product_slug').addClass('is-invalid');
                        $('#product_slug').next().text(data.responseJSON.errors
                            .product_slug[0]);
                    } else if (data.status == 422 && data.responseJSON.errors.product_price) {
                        $('#form-product').removeClass('was-validated');
                        $('#product_price').addClass('is-invalid');
                        $('#product_price').next().text(data.responseJSON.errors
                            .product_price[0]);
                    }
                }
            }
        })
    }

    function update_product(product_id, product_name, product_slug, category_product_id,
        brand_id, product_quantity, product_desc, product_cost, product_price,
        product_price_discount,
        product_image, product_status) {
        let form_data = new FormData();
        form_data.append('product_id', product_id);
        form_data.append('product_name', product_name);
        form_data.append('product_slug', product_slug);
        form_data.append('category_product_id', category_product_id);
        form_data.append('brand_id', brand_id);
        form_data.append('product_quantity', product_quantity);
        form_data.append('product_desc', product_desc);
        form_data.append('product_cost', product_cost);
        form_data.append('product_price', product_price);
        form_data.append('product_price_discount', product_price_discount);
        form_data.append('product_status', product_status);

        if (product_image) {
            console.log(product_image);
            form_data.append('product_image', product_image);
        }
        $.ajax({
            type: "POST",
            url: "{{URL::to('/admin/edit-product')}}",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: form_data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data.status == 200) {
                    show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                        data.message, 'success');
                    $('#modal-product').modal('hide');
                    let url = $('.pagination .page-item.active a').attr('href');
                    let select_value = $('.select-filter-product').val();
                    let search_keyword = $('#keyword-search-product').val();
                    get_product(url, select_value, search_keyword);
                    $('#product_slug').removeClass('is-invalid');
                    $('#product_slug').next().text('Vui lòng nhập slug!');
                    $('#product_price').removeClass('is-invalid');
                    $('#product_price').next().text('Vui lòng nhập giá bán!');
                    $('#product_quantity').removeClass('is-invalid');
                    $('#product_quantity').next().text('Vui lòng nhập số lượng!');
                } else {
                    if (data.status == 500 && data.message ==
                        'Số lượng sản phẩm phải lớn hơn đã bán!') {
                        $('#form-product').removeClass('was-validated');
                        $('#product_quantity').addClass('is-invalid');
                        $('#product_quantity').next().text(data.message);
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                }
            },
            error: function(data) {
                if (data.status == 422) {
                    if (data.responseJSON.errors.product_slug) {
                        $('#form-product').removeClass('was-validated');
                        $('#product_slug').addClass('is-invalid');
                        $('#product_slug').next().text(data.responseJSON.errors
                            .product_slug[0]);
                    } else if (data.status == 422 && data.responseJSON.errors.product_price) {
                        $('#form-product').removeClass('was-validated');
                        $('#product_price').addClass('is-invalid');
                        $('#product_price').next().text(data.responseJSON.errors
                            .product_price[0]);
                    }
                }
            }
        })
    }

    function delete_product(product_id) {
        $.ajax({
            type: "POST",
            url: "{{URL::to('/admin/delete-product')}}",
            data: {
                _token: "{{ csrf_token() }}",
                product_id
            },
            success: function(data) {
                if (data.status == 200) {
                    show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                        .message,
                        'success');
                    $('#modal-confirm-delete').modal('hide');
                    get_product();
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

    function change_status_product(product_id, url) {
        $.ajax({
            type: "GET",
            url: `{{URL::to('/admin/${url}/${product_id}')}}`,
            success: function(data) {
                if (data.status == 200) {
                    show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                        .message,
                        'success');
                    let url = $('.pagination .page-item.active a').attr('href');
                    let select_value = $('.select-filter-product').val();
                    let search_keyword = $('#keyword-search-product').val();
                    get_product(url, select_value, search_keyword);
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

    function set_product_data(data, status) {
        $('#form-product').removeClass('was-validated');

        $('#product_id').val(data.product_id);
        $('#product_name').val(data.product_name);
        $('#product_slug').val(data.product_slug);
        $('#category_product_id').val(data.category_product_id);
        $('#brand_id').val(data.brand_id);
        $('#product_image').val('');
        $('#product_desc').val(data.product_desc);
        $('#product_cost').val(data.product_cost);
        $('#product_price').val(data.product_price);
        $('#product_price_discount').val(data.product_price_discount || 0);
        $('#product_quantity').val(data.product_quantity);
        $('#product_sold').val(data.product_sold);
        $('#product_status').val(data.product_status);

        $('#product_name').prop('disabled', status);
        $('#product_slug').prop('disabled', status);
        $('#category_product_id').prop('disabled', status);
        $('#brand_id').prop('disabled', status);
        $('#product_image').prop('disabled', status);
        $('#product_desc').prop('disabled', status);
        $('#product_cost').prop('disabled', status);
        $('#product_price').prop('disabled', status);
        $('#product_price_discount').prop('disabled', status);
        $('#product_quantity').prop('disabled', status);
        $('#product_sold').prop('disabled', status);
        $('#product_status').prop('disabled', status);
    }

    function get_all_category_product() {
        $.ajax({
            type: "GET",
            url: `{{URL::to('/admin/get-all-category-product')}}`,
            success: function(data) {
                if (data.status == 200) {
                    $('#category_product_id').empty();
                    $('#category_product_id ').append(
                        data.data.map((item) => {
                            return `<option value="${item.category_product_id}">${item.category_product_name}</option>`;
                        }).join('')
                    );
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

    function get_all_brand() {
        $.ajax({
            type: "GET",
            url: `{{URL::to('/admin/get-all-brand')}}`,
            success: function(data) {
                if (data.status == 200) {
                    $('#brand_id').empty();
                    $('#brand_id ').append(
                        data.data.map((item) => {
                            return `<option value="${item.brand_id}">${item.brand_name}</option>`;
                        }).join('')
                    );
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