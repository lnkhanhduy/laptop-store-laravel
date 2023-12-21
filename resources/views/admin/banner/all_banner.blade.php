@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả banner
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-add-banner">
                    Thêm banner
                </button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-banner" aria-label="">
                    <option value="1" selected>Tất cả banner</option>
                    <option value="2">Hiển thị</option>
                    <option value="3">Đã ẩn</option>
                    <option value="4">Hiên thị đã chọn</option>
                    <option value="5">Ẩn đã chọn</option>
                    <option value="6">Xóa đã chọn</option>
                    <option value="7">Tìm kiếm</option>
                </select>
                <input class="btn btn-primary ms-1 d-none btn-filter-banner" type="button" value="Xác nhận">
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-banner" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-banner" type="text" class="form-control">
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
                        <th>Tên banner</th>
                        <th>Hình ảnh</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-banner">

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
<div class="modal fade modal-lg" id="modal-banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="needs-validation" id="form-banner" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-banner"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="banner_id" class="form-control" value="" id="banner_id">
                    <div class="form-group">
                        <label for="banner_name">Tên banner</label>
                        <input type="text" name="banner_name" class="form-control" value="" id="banner_name" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên banner!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh banner</label>
                        <input type="file" name="banner_image" class="form-control" id="banner_image" placeholder=""
                            accept="image/*" required>
                        <div class="invalid-feedback">
                            Vui lòng chọn hình ảnh!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="banner_status">Trạng thái</label>
                        <select name="banner_status" class="form-control form-select" id="banner_status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-banner"></button>
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
        document.title = "Admin - Banner";
        get_banner();

        $('.btn-add-banner').click(function() {
            $('#modal-title-banner').text('Thêm banner');
            $('#banner_image').prop('required', true);
            set_banner_data({}, false);
            $('#banner_status').val('1');
            $('#btn-submit-banner').show();
            $('#btn-submit-banner').text('Thêm');
            $('#modal-banner').modal('show');
        });

        $(document).on('click', '.btn-detail-banner', function() {
            let banner_id = $(this).parent().parent().parent().parent().data('banner-id');
            get_banner_by_id(banner_id).then(function(result) {
                set_banner_data(result, true);
                $('#modal-title-banner').text('Thông tin banner');
                $('#btn-submit-banner').hide();
                $('#modal-banner').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-edit-banner', function() {
            let banner_id = $(this).parent().parent().parent().parent().data('banner-id');
            get_banner_by_id(banner_id).then(function(result) {
                $('#banner_image').prop('required', false);
                set_banner_data(result, false);
                $('#modal-title-banner').text('Cập nhật banner');
                $('#btn-submit-banner').show();
                $('#btn-submit-banner').text('Cập nhật');
                $('#modal-banner').modal('show');
            }).catch(function(error) {
                console.error(error);
            });
        });

        $(document).on('click', '.btn-delete-banner', function() {
            let banner_id = $(this).parent().parent().parent().parent().data('banner-id');
            show_modal_confirm_delete('Bạn muốn xóa banner này', 'data-banner-id', banner_id);
        });

        $(document).on('click', '.btn-active-banner', function() {
            let banner_id = $(this).parent().parent().data('banner-id');
            change_status_banner(banner_id, 'active-banner');
        });

        $(document).on('click', '.btn-unactive-banner', function() {
            let banner_id = $(this).parent().parent().data('banner-id');
            change_status_banner(banner_id, 'unactive-banner');
        });

        $('#btn-submit-confirm-delete').click(function() {
            let data_class = $(this).attr('data-class');
            if (data_class == 'single') {
                let banner_id = $(this).attr('data-banner-id');
                delete_banner(banner_id);
            } else if (data_class == 'multi') {
                let banner_ids = $(this).attr('data-banner-id').split(',');
                $.each(banner_ids, function(key, value) {
                    delete_banner(value);
                });
            }
        })

        $(document).on('change', '.select-filter-banner', function() {
            let select = $(this).val();
            if (select == 1 || select == 2 || select == 3 || select == 7) {
                $('.btn-filter-banner').addClass('d-none');
            } else {
                $('.btn-filter-banner').removeClass('d-none');
            }

            switch (select) {
                case '1':
                    get_banner();
                    break;
                case '2':
                    get_banner(url = "{{URL::to('/admin/get-all-banner-by-status/1')}}", select_value =
                        select);
                    break;
                case '3':
                    get_banner(url = "{{URL::to('/admin/get-all-banner-by-status/0')}}", select_value =
                        select);
                    break;
                default:
                    break;
            }
        })

        $('.btn-filter-banner').click(function() {
            let select = $('.select-filter-banner').val();
            let banner_ids = [];
            $('#tbody-banner > tr').each(function(index, item) {
                if ($(this).find('input').is(':checked')) {
                    let banner_id = $(this).data('banner-id');
                    switch (select) {
                        case '4':
                            change_status_banner(banner_id, 'active-banner');
                            break;
                        case '5':
                            change_status_banner(banner_id, 'unactive-banner');
                            break;
                        case '6':
                            banner_ids.push(banner_id);
                            break;
                        default:
                            break;
                    }
                }
            });
            if (banner_ids.length > 0) {
                show_modal_confirm_delete(
                    'Bạn có chắc muốn xóa tất cả banner này?', 'data-banner-id', banner_ids,
                    'multi');
            }
        })

        $("#form-banner").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let banner_id = $('#banner_id').val();
                let banner_name = $('#banner_name').val();
                let banner_image = $('#banner_image')[0].files[0];
                let banner_status = $('#banner_status').val();

                if (banner_id) {
                    update_banner(banner_id, banner_name, banner_image, banner_status);
                } else {
                    add_banner(banner_name, banner_image, banner_status);
                }
            }
        });

        $('#form-search-banner').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-banner').val();
            if (keyword) {
                get_banner(url = `{{URL::to('/admin/search-banner/${keyword}')}}`, select_value = 7,
                    search_keyword = keyword);
            } else {
                get_banner();
            }
        });

        $('#keyword-search-banner').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_banner();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-banner').val();
            let select_value = $('.select-filter-banner').val();
            get_banner(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-banner').empty();
            $.each(data, function(key, value) {
                $('#tbody-banner').append(
                    `<tr data-banner-id="${value.banner_id}">>
                        <td>
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td class="text-center">${key + 1}</td>
                        <td>${value.banner_name}</td>
                        <td>
                            <img src="{{URL::to('/public/uploads/banner/${value.banner_image}')}}" alt="" width="150px" height="150px" class="object-fit-contain">
                        </td>
                        <td class="text-center">
                            ${value.banner_status == 1 ? 
                                `<button class="btn btn-success btn-sm btn-unactive-banner">Hiển thị</button>`
                                :
                                `<button class="btn btn-danger btn-sm btn-active-banner">Ẩn</button>`
                            }
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-circle-info text-primary btn-detail-banner"></i>
                                </a>
                                <a class="me-2" type="button">
                                    <i class="fa-solid fa-pen-to-square text-warning btn-edit-banner"></i>
                                </a>
                                <a type="button">
                                    <i class="fa-solid fa-trash text-danger btn-delete-banner"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                )
            })
        }

        function get_banner(url = "{{URL::to('/admin/get-all-banner')}}", select_value = 1, search_keyword =
        '') {
            $.ajax({
                type: "GET",
                url,
                data: {
                    pagination: true
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-banner').val(search_keyword);
                        $('.select-filter-banner').val(select_value);
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

        function get_banner_by_id(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: `{{URL::to('/admin/get-banner-by-id/${id}')}}`,
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

        function add_banner(banner_name, banner_image, banner_status) {
            let form_data = new FormData();
            form_data.append('banner_name', banner_name);
            form_data.append('banner_image', banner_image);
            form_data.append('banner_status', banner_status);

            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/add-banner')}}",
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
                        set_banner_data({}, false);
                        $('#banner_status').val('1');
                        get_banner();
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

        function update_banner(banner_id, banner_name, banner_image, banner_status) {
            let form_data = new FormData();
            form_data.append('banner_id', banner_id);
            form_data.append('banner_name', banner_name);
            form_data.append('banner_image', banner_image);
            form_data.append('banner_status', banner_status);

            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/edit-banner')}}",
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
                        $('#modal-banner').modal('hide');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-banner').val();
                        let search_keyword = $('#keyword-search-banner').val();
                        get_banner(url, select_value, search_keyword);
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

        function delete_banner(banner_id) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/delete-banner')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    banner_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_banner();
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

        function change_status_banner(banner_id, url) {
            $.ajax({
                type: "GET",
                url: `{{URL::to('/admin/${url}/${banner_id}')}}`,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        let url = $('.pagination .page-item.active a').attr('href');
                        let select_value = $('.select-filter-banner').val();
                        let search_keyword = $('#keyword-search-banner').val();
                        get_banner(url, select_value, search_keyword);
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

        function set_banner_data(data, status) {
            $('#form-banner').removeClass('was-validated');

            $('#banner_id').val(data.banner_id);
            $('#banner_name').val(data.banner_name);
            $('#banner_image').val('');
            $('#banner_status').val(data.banner_status);

            $('#banner_name').prop('disabled', status);
            $('#banner_image').prop('disabled', status);
            $('#banner_status').prop('disabled', status);
        }
    })
</script>
@endsection