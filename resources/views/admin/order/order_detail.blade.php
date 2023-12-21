@extends('admin_layout')
@section('admin_content')

<div class="card h-100">
    <div class="card-header position-relative">
        Chi tiết đơn hàng
        <div class="position-absolute" style="right: 10px;">
            @if($order->order_status == 0)
            <button class="btn btn-sm btn-success btn-delivery-success"><i class="fa-solid fa-truck"></i> Đã
                giao</button>
            <button class="btn btn-sm btn-danger btn-cancel-order"><i class="fa-solid fa-ban"></i> Hủy</button>
            @endif
            <a class="btn btn-primary btn-sm" href="{{URL::to('/admin/order')}}">Quay lại</a>
        </div>
    </div>
    <div class="card-body h-75 overflow-auto">
        <div class="card">
            <div class="card-header" style="height: auto;padding: 14px 0;">
                <h3 class="text-title">Thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-info b-t b-light table-hover">
                        <thead>
                            <tr>
                                <th class="text-center col-4">Mã đơn hàng</th>
                                <th class="text-center col-4">Ngày đặt</th>
                                <th class="text-center col-4">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$order->order_code}}</td>
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{number_format($order->order_total)}} VND</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-success b-t b-light table-hover">
                        <thead>
                            <tr>
                                <th class="text-center col-4">Ghi chú</th>
                                <th class="text-center col-4">Phương thức thanh toán</th>
                                <th class="text-center col-4">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$order->order_note}}</td>
                                <td class="text-center">
                                    @if($order->order_payment_method == 1)
                                    Tiền mặt
                                    @elseif($order->order_payment_method == 2)
                                    Thẻ ngân hàng
                                    @elseif($order->order_payment_method == 3)
                                    Momo
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($order->order_status == 0)
                                    Đang xử lý
                                    @elseif($order->order_status == 1)
                                    Đã giao
                                    @elseif($order->order_status == 2)
                                    Đã hủy
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header" style="height: auto;padding: 14px 0;">
                <h3 class="text-title">Thông tin người đặt hàng</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-success b-t b-light table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Tên người đặt hàng</th>
                                <th class="text-center">Số điện thoại</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Địa chỉ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$order->order_name}}</td>
                                <td class="text-center">{{$order->order_phone}}</td>
                                <td class="text-center">{{$order->order_email}}</td>
                                <td class="text-center">{{$order->order_address}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header" style="height: auto;padding: 14px 0;">
                <h3 class="text-title">Thông tin sản phẩm</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-primary b-t b-light table-hover">
                        <thead>
                            <tr>
                                <th class="text-center col-6">Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->getOrderDetail as $key => $order_detail_value)
                            <tr>
                                @foreach($order->getProduct as $key => $product_value)
                                @if($order_detail_value->product_id == $product_value->product_id)
                                <td class="col-6">
                                    <div class="row">
                                        <img class="col-4"
                                            src="{{URL::to('/public/uploads/product/'.$product_value->product_image)}}"
                                            style="width: 100px;height: 80px;object-fit: cover">
                                        <p class="col-8 ps-2 mt-1">{{$product_value->product_name}}</p>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                                <td class="text-center">{{$order_detail_value->product_quantity}}</td>
                                <td class="text-center">{{number_format($order_detail_value->product_price)}} VND</td>
                                <td class="text-center">{{number_format(floatval($order_detail_value->product_quantity)
                                    *
                                    floatval($order_detail_value->product_price))}} VND</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('admin_script')
<script type="text/javascript">
    document.title = "Admin - Chi tiết đơn hàng";

    $(document).on('click', '.btn-delivery-success', function() {
        change_status_order("{{$order->order_id}}", 1);
    });

    $(document).on('click', '.btn-cancel-order', function() {
        change_status_order("{{$order->order_id}}", 2);
    });

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
                    location.reload();
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }
</script>
@endsection