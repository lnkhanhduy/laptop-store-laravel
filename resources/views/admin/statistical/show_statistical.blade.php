@extends('admin_layout')
@section('admin_content')

@php
function formatNumber($number) {
if($number >= 1000000000) {
return number_format($number / 1000000000, 1) . 'B';
}elseif ($number >= 1000000) {
return number_format($number / 1000000, 1) . 'M';
} elseif ($number >= 1000) {
return number_format($number / 1000, 1) . 'K';
} else {
return number_format($number);
}
}
@endphp

<div class="card h-100">
    <div class="card-header">
        Thống kê
    </div>
    <div class="card-body">
        <div class="row">
            <div>
                <h2 class="text-title mb-3">Thống kê doanh số</h2>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <p>Từ ngày: </p>
                            <input class="form-control mt-2" type="date" id="statistical-start">
                        </div>
                        <div class="col-md-2">
                            <p>Đến ngày: </p>
                            <input class="form-control mt-2" type="date" id="statistical-end">
                        </div>
                        <div class="col-md-2">
                            <p>Lọc theo</p>
                            <select class="statistical-filter form-select mt-2">
                                <option value="0">--Chọn--</option>
                                <option value="5" selected>Tất cả</option>
                                <option value="1">7 ngày qua</option>
                                <option value="2">Tháng trước</option>
                                <option value="3">Tháng này</option>
                                <option value="4">365 ngày qua</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <input class="btn btn-primary" type="button" id="btn-statistical-filter" value="Xem">
                        </div>
                    </div>
                </form>

                <div class="row my-3">
                    <div class="text-title total-sales-price" style="font-size: 17px">Doanh thu: 0 VND</div>
                    <div class="text-title mt-2 total-profit-price" style="font-size: 17px">Lợi nhuận: 0 VND</div>
                </div>

                <div>
                    <div id="chart-bar" style="height: 200px"></div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-4">
                    <h2 class="text-title text-center">Tổng quan</h2>
                    <div id="chart-donut" style="height: 200px"></div>
                </div>
                <div class="col-sm-4">
                    <h2 class="text-title text-center mb-2">Bài viết xem nhiều</h2>
                    <div>
                        <ul>
                            @foreach($post_view as $key => $post)
                            <li style="list-style-type: none;margin-bottom: 4px" class="row">
                                {{$key+1}}.
                                <a class="text-primary col-8" href="{{URL::to('/bai-viet/'.$post->post_slug)}}">
                                    {{\Illuminate\Support\Str::words($post->post_title, 5, '...')}}
                                </a>
                                <p class="col-3">
                                    |<i class="fa-solid fa-eye"
                                        style="color: #a8328e;font-size: 13px; margin:0 3px"></i>{{formatNumber($post->post_views)}}
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4">
                    <h2 class="text-title text-center mb-2">Sản phẩm xem nhiều</h2>
                    <ul>
                        @foreach($product_view as $key => $pro)
                        <li style="list-style-type: none;margin-bottom: 4px;" class="row">
                            {{$key+1}}.
                            <a class="text-primary col-8" href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_slug)}}">
                                {{\Illuminate\Support\Str::words($pro->product_name, 5, '...') }}
                            </a>
                            <p class="col-3">
                                |<i class="fa-solid fa-eye"
                                    style="color: #a8328e;font-size: 13px; margin:0 3px"></i>{{formatNumber($pro->product_views)}}
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Thống kê";

        filter_by_option(5);

        show_chart_donut('{{$product_count??0}}', '{{$order_count??0}}', '{{$user_count??0}}',
            '{{$post_count??0}}');

        $('#btn-statistical-filter').click(function() {
            let from_date = $('#statistical-start').val();
            let to_date = $('#statistical-end').val();

            if (from_date != '' && to_date != '') {
                $.ajax({
                    url: "{{URL::to('/admin/filter-by-date')}}",
                    method: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        from_date,
                        to_date
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 200) {
                            $('#chart-bar').empty();
                            $('.total-sales-price').text(
                                `Doanh thu: ${format_currency(data.data[1])}`);
                            $('.total-profit-price').text(
                                `Lợi nhuận: ${format_currency(data.data[2])}`);
                            if (data.data[0].length > 0) {
                                $('.statistical-filter').val(0);
                                show_chart_bar(data.data[0]);
                            }
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }
        });

        $('.statistical-filter').change(function() {
            let value = $(this).val();
            if (value != 0) {
                filter_by_option(value);
            } else {
                $('#chart-bar').empty();
                $('.total-sales-price').text(
                    `Doanh thu: 0 VND`);
                $('.total-profit-price').text(
                    `Lợi nhuận: 0 VND`);
                show_chart_bar([{
                    statistical_date: 0,
                    statistical_total_order: 0,
                    statistical_sales: 0,
                    statistical_profit: 0,
                    statistical_quantity: 0
                }]);
            }
        })

        function filter_by_option(value) {
            $.ajax({
                url: "{{URL::to('/admin/filter-by-option')}}",
                method: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    value
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#chart-bar').empty();
                        $('.total-sales-price').text(
                            `Doanh thu: ${format_currency(data.data[1])}`);
                        $('.total-profit-price').text(
                            `Lợi nhuận: ${format_currency(data.data[2])}`);
                        if (data.data[0].length > 0) {
                            show_chart_bar(data.data[0]);
                            $('#statistical-start').val('');
                            $('#statistical-end').val('');
                        }
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            })
        }

        function show_chart_bar(chart_data) {
            return new Morris.Bar({
                element: 'chart-bar',
                lineColors: [
                    '#819C79', '#fc8710', '#FF6541', '#A4Add3', '#766B56'
                ],
                hideHover: 'auto',
                parseTime: false,
                gridTextWeight: "bold",
                data: chart_data,
                xkey: 'statistical_date',
                ykeys: [
                    'statistical_total_order', 'statistical_quantity', 'statistical_sales',
                    'statistical_profit',

                ],
                labels: [
                    'Đơn hàng', 'Sản phẩm bán', 'Doanh số', 'Lợi nhuận'
                ]
            });
        }

        function show_chart_donut(product_count, order_count, user_count, post_count) {
            return new Morris.Donut({
                element: 'chart-donut',
                resize: true,
                colors: [
                    '#a8328e',
                    '#61a1ce',
                    '#ce8f61',
                    '#f5b942',
                    '#4842f5'
                ],
                data: [{
                        label: 'Sản phẩm',
                        value: product_count
                    },
                    {
                        label: 'Đơn hàng',
                        value: order_count
                    },
                    {
                        label: 'Khách hàng',
                        value: user_count
                    },
                    {
                        label: 'Bài viết',
                        value: post_count
                    },
                ],
            })
        }
    })
</script>
@endsection