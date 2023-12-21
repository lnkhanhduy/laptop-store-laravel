@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>
    <div class="container">
        <h2 class="text-title text-start mb-3 ms-2">Thanh toán</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="needs-validation" id="form-checkout" method="POST"
                        action="{{URL::to('/add-order-user')}}" novalidate>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <h3 style="font-size: 20px; text-transform: uppercase">Thông tin người mua</h3>
                            @csrf
                            <input type="hidden" type="number" name="total" class="input-total-payment">
                            <input type="hidden" name="voucher_id" value="" id="checkout_voucher_id">
                            <input type="hidden" name="data_cart_id" value="{{$data_cart_id}}">
                            <div class="form-group w-100">
                                <input type="text" class="form-control mt-4" name="name" id="name"
                                    placeholder="Họ và tên" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập họ và tên!
                                </div>
                            </div>
                            <div class="form-group w-100">
                                <input type="text" class="form-control mt-2" name="address" id="address"
                                    placeholder="Địa chỉ" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập địa chỉ!
                                </div>
                            </div>
                            <div class="form-group w-100">
                                <input type="email" class="form-control mt-2" name="email" id="email"
                                    placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập đúng định dạng email!
                                </div>
                            </div>

                            <div class="form-group w-100">
                                <input type="number" class="form-control mt-2" name="phone" id="phone"
                                    placeholder="Số điện thoại" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập số điện thoại!
                                </div>
                            </div>
                            <div class="form-group w-100">
                                <select class="form-select mt-2" name="payment_method" id="payment_method" required>
                                    <option value="" selected>Chọn phương thức thanh toán</option>
                                    <option value="1">Tiền mặt</option>
                                    <option value="2">Thẻ ngân hàng</option>
                                    <option value="3">Momo</option>
                                </select>
                                <div class="invalid-feedback">
                                    Vui lòng chọn phương thức thanh toán!
                                </div>
                            </div>

                            <textarea class="form-control mt-2" placeholder="Ghi chú đơn hàng (Nếu có)"></textarea>

                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                Thanh toán
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-bottom p-3" style="font-size: 16px;">
                        <div class="col-6">Sản phẩm</div>
                        <div class="col-2 text-end">Đơn giá</div>
                        <div class="col-2 text-end">Số lượng</div>
                        <div class="col-2 text-end">Thành tiền</div>
                    </div>
                    <div class="card-body">
                        @php
                        $total = 0;
                        @endphp

                        @foreach($cart as $cart_value)
                        @php
                        if($cart_value->getProduct->product_price_discount!=0){
                        $total += $cart_value->quantity*$cart_value->getProduct->product_price_discount;
                        }
                        else{
                        $total += $cart_value->quantity*$cart_value->getProduct->product_price;
                        }
                        @endphp
                        <div class="d-flex border-bottom mt-2 pb-2">
                            <div class="col-6 d-flex">
                                <div class="col-4">
                                    <img src="{{URL::to('/public/uploads/product/'.$cart_value->getProduct->product_image)}}"
                                        style="width: 100%; height: 90px; object-fit: cover">
                                </div>
                                <div class="col-8 ps-3">
                                    <p class="card-title mt-1">{{$cart_value->getProduct->product_name}}</p>
                                </div>
                            </div>
                            <div class="col-2 text-end mt-1">
                                @if($cart_value->getProduct->product_price_discount!=0)
                                {{number_format($cart_value->getProduct->product_price_discount) . ' VND'}}
                                @else
                                {{number_format($cart_value->getProduct->product_price) . ' VND'}}
                                @endif
                            </div>
                            <div class="col-2 d-flex justify-content-end align-items-start">
                                <input class="text-center form-control input-quantity-product" type="number"
                                    value="{{$cart_value->quantity}}" min="1" style="width: 60px; flex: none;" disabled>
                            </div>
                            <div class="col-2 mt-1 text-end">
                                @if($cart_value->getProduct->product_price_discount!=0)
                                {{number_format($cart_value->quantity*$cart_value->getProduct->product_price_discount)
                                .' VND'}}
                                @else
                                {{number_format($cart_value->quantity*$cart_value->getProduct->product_price) .' VND'}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer p-3">
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="" id="code-discount"
                                    placeholder="Nhập mã giảm giá (Nếu có)">
                                <button class="btn btn-primary btn-get-discount">Lấy mã</button>
                            </div>
                            <p class="text-danger fw-bold mt-2 ms-1 error-check-discount d-none"></p>
                        </div>
                        <div class="row mt-2">
                            <span class="text-start col-6 fw-bold">Mã giảm giá:</span>
                            <span class="text-end col-6 text-discount-payment fw-bold" style="font-size: 14px">0
                                VND</span>
                        </div>
                        <div class="row mt-2">
                            <span class="text-start col-6 fw-bold" style="color: blue;font-size: 18px">Thành
                                tiền:</span>
                            <div class="text-end col-6">
                                <span class="text-total-payment-old d-none"
                                    style="color: blue;font-size: 14px;text-decoration: line-through">{{number_format($total)}}
                                    VND
                                </span>
                                <span class="fw-bold text-total-payment"
                                    style="color: blue;font-size: 18px">{{number_format($total)}}
                                    VND
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        let payment = parseInt($('.text-total-payment').text().replace(/[^0-9]/g, ""));
        $('.input-total-payment').val(payment);

        $('.btn-get-discount').click(function() {
            let code_discount = $('#code-discount').val();

            if (code_discount != '') {
                $('#checkout_voucher_id').val('');
                check_discount_code(code_discount);
            }
        })

        $('#form-checkout').submit(function(e) {
            e.preventDefault()
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                this.submit();
            }
        });

        function check_discount_code(code_discount) {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/check-discount-code-user')}}",
                data: {
                    code_discount
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('#checkout_voucher_id').val(data.data.voucher_id);
                        $('.error-check-discount').addClass('d-none');
                        $('.text-total-payment-old').removeClass('d-none');
                        $('.text-total-payment-old').text(format_currency(payment));
                        if (data.data.voucher_type == 1) {
                            $('.text-discount-payment').text("-" + format_currency(data.data
                                .voucher_discount_amount));
                            $('.text-total-payment').text(format_currency(payment - data.data
                                .voucher_discount_amount))
                            $('.input-total-payment').val(payment - data.data
                                .voucher_discount_amount)
                        } else {
                            let discount = data.data.voucher_discount_amount *
                                payment / 100;
                            $('.text-discount-payment').text('-' + format_currency(
                                    discount) + ' (-' + data.data.voucher_discount_amount +
                                '%)');
                            $('.text-total-payment').text(format_currency(payment - discount))
                            $('.input-total-payment').val(payment - discount)
                        }
                    } else if (data.status == 422) {
                        $('.error-check-discount').removeClass('d-none');
                        $('.error-check-discount').text(data.message);
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            })
        }
    })
</script>
@endsection
<!-- End script -->