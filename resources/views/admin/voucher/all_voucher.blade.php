@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả mã giảm giá
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-voucher">
                    Thêm mã giảm giá
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-voucher" aria-label="">
                    <option value="1" selected>Tất cả mã giảm giá</option>
                    <option value="2">Hoạt động</option>
                    <option value="3">Chưa kích hoạt</option>
                    <option value="4">Đã sử dụng hết</option>
                    <option value="5">Hiên thị đã chọn</option>
                    <option value="6">Ẩn đã chọn</option>
                    <option value="7">Xóa đã chọn</option>
                    <option value="8">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-voucher" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-voucher" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-voucher" type="text" class="form-control">
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
                        <th>Tên mã giảm giá</th>
                        <th>Mã giảm giá</th>
                        <th>Số lượng</th>
                        <th>Giảm</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-voucher">

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
<div class="modal fade modal-lg" id="modal-voucher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-voucher" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-voucher"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="voucher_id" class="form-control" value="" id="voucher_id">
                    <div class="form-group">
                        <label for="voucher_name">Tên mã giảm giá</label>
                        <input type="text" name="voucher_name" class="form-control" value="" id="voucher_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên mã giảm giá!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voucher_code">Mã giảm giá</label>
                        <div class="input-group">
                            <input type="text" name="voucher_code" class="form-control" value="" id="voucher_code"
                                required>
                            <button type="button" class="btn btn-primary btn-generate-voucher-code">Ngẫu nhiên</button>
                            <div class="invalid-feedback">
                                Vui lòng nhập mã giảm giá!
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="voucher_quantity">Số lượng</label>
                            <input type="text" name="voucher_quantity" class="form-control" value=""
                                id="voucher_quantity" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập số lượng!
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="voucher_used">Đã sử dụng</label>
                            <input type="text" name="voucher_used" value="0" class="form-control" value="0"
                                id="voucher_used" readonly disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="voucher_quantity">Giảm theo</label>
                            <select name="voucher_type" class="form-control form-select" id="voucher_type">
                                <option value="1">Giảm theo tiền</option>
                                <option value="2">Giảm theo phần trăm</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="voucher_discount_amount">Số tiền/phần trăm giảm</label>
                            <input type="number" name="voucher_discount_amount" class="form-control" value=""
                                id="voucher_discount_amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voucher_status">Trạng thái</label>
                        <select name="voucher_status" class="form-control form-select" id="voucher_status">
                            <option value="0">Chưa thể sử dụng</option>
                            <option value="1">Có thể sử dụng</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-voucher"></button>
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
        document.title = 'Admin - Mã giảm giá';
        get_voucher();

        $('.btn-add-voucher').click(function() {
            $('#modal-title-voucher').text('Thêm voucher');
            set_voucher_data({}, false);
            $('.btn-generate-voucher-code').prop('disabled', false);
            $('#voucher_status').empty();
            $('#voucher_status').append(`
                <option value="0">Chưa thể sử dụng</option>
                <option value="1">Có thể sử dụng</option>
            `);
            $('#voucher_type').val('1');
            $('#btn-submit-voucher').show();
            $('#btn-submit-voucher').text('Thêm');
            $('#modal-voucher').modal('show');
        });

        $(document).on('click', '.btn-generate-voucher-code', function() {
            $('#voucher_code').val(generateVoucherCode());
        });

        $(document).on('click', '.btn-detail-voucher', function() {
            let voucher_id = $(this).parent().parent().parent().parent().data('voucher-id');
            get_voucher_by_id(voucher_id).then(function(result) {
                $('#voucher_status').empty();
                $('#voucher_status').append(`
                    <option value="0">Chưa thể sử dụng</option>
                    <option value="1">Có thể sử dụng</option>
                    <option value="2">Đã sử dụng hết</option>
                `);
                set_voucher_data(result, true);
                $('.btn-generate-voucher-code').prop('disabled', true);
                $('#modal-title-voucher').text('Thông tin voucher');
                $('#btn-submit-voucher').hide();
                $('#modal-voucher').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-edit-voucher', function() {
            let voucher_status = $(this).parent().parent().data('status');
            if (voucher_status == 2) {
                return;
            }

            let voucher_id = $(this).parent().parent().parent().parent().data('voucher-id');
            get_voucher_by_id(voucher_id).then(function(result) {
                $('#voucher_status').empty();
                $('#voucher_status').append(`
                    <option value="0">Chưa thể sử dụng</option>
                    <option value="1">Có thể sử dụng</option>
                `);
                $('.btn-generate-voucher-code').prop('disabled', false);
                $('#voucher_image').prop('required', false);
                set_voucher_data(result, false);
                $('#modal-title-voucher').text('Cập nhật voucher');
                $('#btn-submit-voucher').show();
                $('#btn-submit-voucher').text('Cập nhật');
                $('#modal-voucher').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-delete-voucher', function() {
            let voucher_id = $(this).parent().parent().parent().parent().data('voucher-id');
            show_modal_confirm_delete('Bạn muốn xóa voucher này', 'data-voucher-id', voucher_id);
        });

        $(document).on('click', '.btn-active-voucher', function() {
            let voucher_id = $(this).parent().parent().data('voucher-id');
            change_status_voucher(voucher_id, 'active-voucher');
        });

        $(document).on('click', '.btn-unactive-voucher', function() {
            let voucher_id = $(this).parent().parent().data('voucher-id');
            change_status_voucher(voucher_id, 'unactive-voucher');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let voucher_id = $(this).attr('data-voucher-id');
                delete_voucher(voucher_id);
            } else if (data_class == 'multi') {
                let voucher_ids = $(this).attr('data-voucher-id').split(',');
                $.each(voucher_ids, function(key, value) {
                    delete_voucher(value);
                });
            }
        })

        $(document).on('change', '.select-filter-voucher', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 4 || select == 8) {
                $('.btn-filter-voucher').addClass('d-none');
            } else {
                $('.btn-filter-voucher').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_voucher();
                    break;
                case '2':
                    get_voucher(url = "{{URL::to('/admin/get-all-voucher-by-status/1')}}",
                        select_value =
                        select);
                    break;
                case '3':
                    get_voucher(url = "{{URL::to('/admin/get-all-voucher-by-status/0')}}",
                        select_value =
                        select);
                    break;
                case '4':
                    get_voucher(url = "{{URL::to('/admin/get-all-voucher-by-status/2')}}",
                        select_value =
                        select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-voucher').click(function() {
            let select = $('.select-filter-voucher').val();
            let voucher_ids = [];
            $('#tbody-voucher > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let voucher_id = $(this).data('voucher-id');
                    switch (select) {
                        case '5':
                            change_status_voucher(voucher_id, 'active-voucher');
                            break;
                        case '6':
                            change_status_voucher(voucher_id, 'unactive-voucher');
                            break;
                        case '7':
                            voucher_ids.push(voucher_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (voucher_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả voucher này?', 'data-voucher-id', voucher_ids,
                    'multi');
            }
        })

        $("#form-voucher").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let voucher_id = $('#voucher_id').val();
                let voucher_name = $('#voucher_name').val();
                let voucher_code = $('#voucher_code').val();
                let voucher_quantity = $('#voucher_quantity').val();
                let voucher_used = $('#voucher_used').val();
                let voucher_type = $('#voucher_type').val();
                let voucher_discount_amount = $('#voucher_discount_amount').val();
                let voucher_status = $('#voucher_status').val();


                if (voucher_id) {
                    update_voucher(voucher_id, voucher_name, voucher_code, voucher_quantity,
                        voucher_used, voucher_type, voucher_discount_amount,
                        voucher_status);
                } else {
                    add_voucher(voucher_name, voucher_code, voucher_quantity,
                        voucher_type, voucher_discount_amount, voucher_status);
                }
            }
        });

        $('#form-search-voucher').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-voucher').val();
            if (keyword) {
                get_voucher(url = `{{URL::to('/admin/search-voucher/${keyword}')}}`, select_value = 7,
                    search_keyword = keyword);
            } else {
                get_voucher();
            }
        });

        $('#keyword-search-voucher').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_voucher();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-voucher').val();
            let select_value = $('.select-filter-voucher').val();
            get_voucher(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-voucher').empty();
            $.each(data, function(key, value) {
                $('#tbody-voucher').append(
                    `<tr data-voucher-id="${value.voucher_id}">
                        <td>
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td class="text-center">${key + 1}</td>
                        <td>${value.voucher_name}</td>
                        <td>${value.voucher_code}</td>                     
                        <td>${value.voucher_quantity}</td>                     
                        <td>${value.voucher_type==1 ?`${format_currency(value.voucher_discount_amount)}`:`${value.voucher_discount_amount}%`}</td>                     
                        <td class="text-center">
                            ${value.voucher_status == 1 ?
                                `<button class="btn btn-success btn-sm btn-unactive-voucher">Đã kích hoạt</button>` :
                            value.voucher_status == 0 ?
                                `<button class="btn btn-danger btn-sm btn-active-voucher">Chưa kích hoạt</button>`:
                                `<button class="btn btn-warning btn-sm" style="cursor: not-allowed">Đã sử dụng hết</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center" data-status="${value.voucher_status}">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-voucher"></i>
                                </a>
                                ${value.voucher_status == 2 ?
                                    `<a class="me-2" type="button" style="cursor: not-allowed;">
                                        <i class="fa-solid fa-pen-to-square text-warning btn-edit-voucher"></i>
                                    </a>`:
                                    `<a class="me-2" type="button">
                                        <i class="fa-solid fa-pen-to-square text-warning btn-edit-voucher"></i>
                                    </a> `
                                }
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-voucher"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                );
            });
        }

        function get_voucher(url = "{{URL::to('/admin/get-all-voucher')}}", select_value = 1, search_keyword =
            '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-voucher').val(search_keyword);
                        $('.select-filter-voucher').val(select_value);
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

        function get_voucher_by_id(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-voucher-by-id/${id}')}}`,
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

        function add_voucher(voucher_name, voucher_code, voucher_quantity,
            voucher_type, voucher_discount_amount, voucher_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-voucher')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    voucher_name,
                    voucher_code,
                    voucher_quantity,
                    voucher_type,
                    voucher_discount_amount,
                    voucher_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        set_voucher_data({}, false);
                        $('#voucher_status').val('1');
                        $('#voucher_type').val('1');
                        get_voucher();
                        $('#voucher_code').removeClass('is-invalid');
                        $('#voucher_code').next().next().text('Vui lòng mã giảm giá!');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.voucher_code) {
                        $('#form-voucher').removeClass('was-validated');
                        $('#voucher_code').addClass('is-invalid');
                        $('#voucher_code').next().next().text(data.responseJSON.errors
                            .voucher_code[0]);
                    } else {
                        console.log(data);
                    }
                }
            })
        }

        function update_voucher(voucher_id, voucher_name, voucher_code, voucher_quantity,
            voucher_type, voucher_discount_amount, voucher_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/edit-voucher')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    voucher_id,
                    voucher_name,
                    voucher_code,
                    voucher_quantity,
                    voucher_type,
                    voucher_discount_amount,
                    voucher_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#modal-voucher').modal('hide');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-voucher').val();
                        let search_keyword = $('#keyword-search-voucher').val();
                        get_voucher(url, select_value, search_keyword);
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        function delete_voucher(voucher_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-voucher')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    voucher_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_voucher();
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

        function change_status_voucher(voucher_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${voucher_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data
                            .message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-voucher').val();
                        let search_keyword = $('#keyword-search-voucher').val();
                        get_voucher(url, select_value, search_keyword);
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

        function set_voucher_data(data, status) {
            $('#form-voucher').removeClass('was-validated');

            $('#voucher_id').val(data.voucher_id);
            $('#voucher_name').val(data.voucher_name);
            $('#voucher_code').val(data.voucher_code);
            $('#voucher_quantity').val(data.voucher_quantity);
            $('#voucher_used').val(data.voucher_used);
            $('#voucher_type').val(data.voucher_type);
            $('#voucher_discount_amount').val(data.voucher_discount_amount);
            $('#voucher_desc').val(data.voucher_desc);
            $('#voucher_status').val(data.voucher_status);

            $('#voucher_name').prop('disabled', status);
            $('#voucher_code').prop('disabled', status);
            $('#voucher_quantity').prop('disabled', status);
            $('#voucher_type').prop('disabled', status);
            $('#voucher_discount_amount').prop('disabled', status);
            $('#voucher_desc').prop('disabled', status);
            $('#voucher_status').prop('disabled', status);
        }

        function generateVoucherCode() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            const codeLength = 10;
            let discountCode = '';

            for (let i = 0; i < codeLength; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                discountCode += characters[randomIndex];
            }

            return discountCode;
        }
    })
</script>
@endsection