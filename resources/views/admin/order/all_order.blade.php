@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header">
        Tất cả đơn hàng
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-4 d-flex">
                <select class="form-select select-filter-order" aria-label="">
                    <option value="1" selected>Tất cả đơn hàng</option>
                    <option value="2">Đã giao</option>
                    <option value="3">Đã hủy</option>
                    <option value="4">Đang xử lý</option>
                    <option value="5">Tìm kiếm</option>
                </select>
            </div>
            <div class=" col-md-2"></div>
            <div class="col-md-3">
                <form id="form-search-order" class="d-flex">
                    <input placeholder="Nhập từ khoá" id="keyword-search-order" type="text" class="form-control">
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
                        <th class="text-center">#</th>
                        <th class="col-1">Mã đơn hàng</th>
                        <th class="col-3">Người đặt hàng</th>
                        <th class="text-center col-2">Ngày đặt hàng</th>
                        <th class="text-end col-2">Tổng tiền</th>
                        <th class="text-end col-2">Trạng thái</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody id="tbody-order">

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
        document.title = "Admin - Đơn hàng";
        get_order();

        $(document).on('click', '.btn-delivery-success', function() {
            let order_id = $(this).parent().parent().data('order-id');
            change_status_order(order_id, 1);
        });

        $(document).on('click', '.btn-cancel-order', function() {
            let order_id = $(this).parent().parent().data('order-id');
            change_status_order(order_id, 2);
        });

        $(document).on('change', '.select-filter-order', function() {
            let select = $(this).val();

            switch (select) {
                case '1':
                    get_order();
                    break;
                case '2':
                    get_order(url = "{{URL::to('/admin/get-all-order-by-status/1')}}", select_value =
                        select);
                    break;
                case '3':
                    get_order(url = "{{URL::to('/admin/get-all-order-by-status/2')}}", select_value =
                        select);
                    break;
                case '4':
                    get_order(url = "{{URL::to('/admin/get-all-order-by-status/0')}}", select_value =
                        select);
                    break;
                default:
                    break;
            }
        })

        $('#form-search-order').submit(function(e) {
            e.preventDefault();
            let keyword = $('#keyword-search-order').val();
            if (keyword) {
                get_order(url = `{{URL::to('/admin/search-order/${keyword}')}}`, select_value = 5,
                    search_keyword = keyword);
            } else {
                get_order();
            }
        });

        $('#keyword-search-order').keyup(function(e) {
            if ($(this).val().length == 0) {
                get_order();
            }
        })

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let keyword = $('#keyword-search-order').val();
            let select_value = $('.select-filter-order').val();
            get_order(url, select_value = select_value, search_keyword =
                keyword);
        })

        function load_data_table(data) {
            $('#tbody-order').empty();
            $.each(data, function(key, value) {
                $('#tbody-order').append(
                    `<tr data-order-id="${value.order_id}">
                        <td class="text-center">${key + 1}</td>
                        <td> ${value.order_code}</td>
                        <td>${value.order_name}</td>
                        <td class="text-center">${formattedTime(value.order_created_at)}</td>
                        <td class="text-end">${format_currency(value.order_total)}</td>
                        <td class="text-end">
                            ${value.order_status==0? "<span class='badge bg-primary'>Đang xử lý</span>": value.order_status==1? "<span class='badge bg-success'>Đã giao</span>": "<span class='badge bg-danger'>Đã hủy</span>"}
                        </td>
                        <td class="text-start">
                        <a href="{{URL::to('/order-detail/${value.order_id}')}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                            ${value.order_status==0? `
                                <button class="btn btn-sm btn-success btn-delivery-success"><i class="fa-solid fa-truck"></i></button>
                                <button class="btn btn-sm btn-danger btn-cancel-order"><i class="fa-solid fa-ban"></i></button>
                                `: ''}
                        </td>
                    </tr>`
                )
            })
        }

        function get_order(url = "{{URL::to('/admin/get-all-order')}}", select_value = 1, search_keyword = '') {
            $.ajax({
                type: "GET",
                url,
                success: function(data) {
                    if (data.status == 200) {
                        $('#keyword-search-order').val(search_keyword);
                        $('.select-filter-order').val(select_value);
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

        function change_status_order(order_id, order_status) {
            $.ajax({
                type: "POST",
                url: "{{URL::to('/admin/change-status-order')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id,
                    order_status
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>', data.message,
                            'success');
                        let search_keyword = $('#keyword-search-order').val();
                        let select_value = $('.select-filter-order').val();
                        let url = $('.pagination .page-item.active a').attr('href');
                        get_order(url, select_value, search_keyword);
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