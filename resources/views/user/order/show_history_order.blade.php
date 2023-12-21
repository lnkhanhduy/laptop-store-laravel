@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
        </ol>
    </nav>
    <div class="container">
        <h2 class="text-title text-start mb-3 ms-2">Lịch sử mua hàng</h2>


        <div class="card">
            <div class="card-header border-bottom py-3" style="font-size: 16px;">
                <div class="col-1 fw-bold ps-3">Mã ĐH</div>
                <div class="col-5 fw-bold ps-3">Sản phẩm</div>
                <div class="col-2 text-center fw-bold">Ngày đặt</div>
                <div class="col-2 text-end fw-bold">Tổng tiền</div>
                <div class="col-2 text-end fw-bold">Trạng thái</div>
            </div>
            <div class="card-body" id="list-history-order">
                @if(count($order) == 0)
                <span>Bạn chưa mua sản phẩm!</span>
                @else
                @foreach($order as $key => $order_value)
                <div class="row border-bottom mt-2 pb-2">
                    <div class="col-1">
                        {{$order_value->order_code}}
                    </div>
                    <div class="col-5 ps-3">
                        @foreach($order_detail[$key] as $index => $order_detail_value)
                        <div
                            class="row mt-1 @if(count($order_detail[$key]) != 1 && $index != count($order_detail[$key])-1) border-bottom pb-1 @endif">
                            <div class="col-8">
                                <a class="d-flex"
                                    href="{{URL::to('/chi-tiet-san-pham/'.$order_detail_value->getProduct->product_slug)}}">
                                    <img src="{{URL::to('/public/uploads/product/'.$order_detail_value->getProduct->product_image)}}"
                                        width="80px" height="80px" class="object-fit-cover">
                                    <div>
                                        <span
                                            class="card-title px-3">{{$order_detail_value->getProduct->product_name}}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-4">
                                <p>Số lượng: {{$order_detail_value->product_quantity}}</p>
                                <p class="mt-2">Đơn giá: {{number_format($order_detail_value->product_price)}} VND</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-2 text-center">{{$order_value->created_at}}</div>
                    <div class="col-2 text-end">
                        {{number_format($order_value->order_total)}} VND
                    </div>
                    <div class="col-2 text-end">
                        @if($order_value->order_status == 0)
                        <span class="badge bg-warning">Đang xử lý</span>
                        @elseif($order_value->order_status == 1)
                        <span class="badge bg-success">Đã giao</span>
                        @elseif($order_value->order_status == 2)
                        <span class="badge bg-danger">Đã hủy</span>
                        @endif
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