@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
        </ol>
    </nav>
    <div class="">
        <h2 class="text-title text-start mb-3 ms-2">Lịch sử mua hàng</h2>

        <div class="card">
            <div class="card-body history-order-list">
                @if(count($order) == 0)
                <span>Bạn chưa mua sản phẩm!</span>
                @else
                @foreach($order as $key => $order_value)
                <div class="history-order-item">
                    <a href="#" class="d-flex justify-content-between px-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample{{$order_value->order_id}}" aria-expanded="false"
                        aria-controls="collapseExample{{$order_value->order_id}}">
                        <div class="col-7">Ngày đặt: {{$order_value->created_at}}</div>
                        <div>
                            @if($order_value->order_status == 0)
                            <span class="badge text-bg-secondary">Đang xử lý</span>
                            @elseif($order_value->order_status == 1)
                            <span class="badge text-bg-primary">Đang giao</span>
                            @elseif($order_value->order_status == 2)
                            <span class="badge text-bg-success">Đã giao</span>
                            @elseif($order_value->order_status == 3)
                            <span class="badge text-bg-danger">Đã huỷ</span>
                            @endif
                        </div>
                    </a>

                    <div class="collapse" id="collapseExample{{$order_value->order_id}}">
                        <div class="table-responsive pt-2">
                            <table class="table table-info table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <td>Họ tên: {{$order_value->order_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại: {{$order_value->order_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ: {{$order_value->order_address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú: {{$order_value->order_note}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if($order_value->order_payment_method == 'cod_payment')
                                            Thanh toán khi nhận hàng
                                            @else
                                            Thanh toán online
                                            @endif
                                    </tr>
                                    <tr>
                                        <td>Tổng tiền: {{number_format($order_value->order_total)}} VND</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive history-order-item-list-product px-3">
                            <table class="table table-secondary" style="border-radius: 5px; overflow: hidden">
                                <thead>
                                    <tr>
                                        <th class="col-6">Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_value->getOrderDetail as $key => $order_detail_value)
                                    <tr>
                                        <td class="p-2">
                                            <a
                                                href="{{URL::to('/chi-tiet-san-pham/' . $order_detail_value->getProduct->product_slug)}}">
                                                <div class="cart-product-item-img">
                                                    <img src="{{URL::to('/public/uploads/product/' . $order_detail_value->getProduct->product_image)}}"
                                                        alt="Hình ảnh sản phẩm">
                                                </div>
                                                <p class="product-name-overflow mt-1 w-50">
                                                    {{$order_detail_value->getProduct->product_name}}
                                                </p>
                                            </a>
                                        </td>
                                        <td>{{$order_detail_value->product_quantity}}</td>
                                        <td>{{number_format($order_detail_value->product_price)}} VND</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
</script>
@endsection
<!-- End script -->