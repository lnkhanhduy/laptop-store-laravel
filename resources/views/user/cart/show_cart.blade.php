@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav>
    <div class="">
        <h2 class="text-title text-start mb-3 ms-2">Giỏ hàng</h2>

        <div class="cart-content">
            <div class="cart-column cart-list-product table-responsive">

            </div>
            <div class="cart-column">
                <h2 class="fs-3 fw-bold text-center">Thông tin đơn hàng</h2>
                <form method="POST" action="{{URL::to('/save-order')}}" class="needs-validation" id="form_order"
                    novalidate>
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control mt-3" name="order_name" placeholder="Họ và tên" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập họ và tên!
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" name="order_phone" placeholder="Số điện thoại"
                            required>
                        <div class="invalid-feedback">
                            Vui lòng nhập số điện thoại!
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" name="order_address" placeholder="Địa chỉ"
                            required>
                        <div class="invalid-feedback">
                            Vui lòng nhập địa chỉ!
                        </div>
                    </div>
                    <textarea class="form-control mt-2" name="order_note" placeholder="Ghi chú (Nếu có)"></textarea>
                    <div class="form-group">
                        <select class="form-select mt-2" id="order_payment" name="order_payment" required>
                            <option value="" selected>Phương thức thanh toán</option>
                            <option value="cod_payment">Thanh toán khi nhận hàng</option>
                        </select>
                        <div class="invalid-feedback">
                            Vui lòng chọn phương thức thanh toán!
                        </div>
                    </div>
                    <p class="fs-5 mt-3 ps-1 fw-bold">Tổng tiền:&nbsp;
                        <span class="total-cart-price"></span>
                        <input name="order_total" id="order_total" type="hidden" value="">
                    </p>
                    <button type="submit" class="btn btn-dark mt-3 w-100">Thanh toán</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    document.title = "Giỏ hàng";

    get_cart();

    $(document).on('click', '.btn-delete-cart', function() {
        let cart_id = $(this).parent().parent().data('cart-id');
        delete_cart(cart_id);
    });

    $(document).on('click', '.btn-sub-product', function() {
        let cart_id = $(this).parent().parent().parent().data('cart-id')
        let quantity = parseInt($(this).parent().find('.input-quantity-product').val());
        let max_quantity = parseInt($(this).parent().parent().parent().find(
            '.input-quantity-product').attr(
            'max'));

        if (quantity >= 1 && quantity <= max_quantity) {
            $(this).parent().find('.btn-add-product').attr('disabled', false);

            if (quantity == 2) {
                quantity--;
                $(this).parent().find('.input-quantity-product').val(quantity);
                $(this).attr('disabled', true);
            } else {
                quantity--;
                $(this).parent().find('.input-quantity-product').val(quantity);
            }
            change_quantity(cart_id, quantity);
        }
    });

    $(document).on('click', '.btn-add-product', function() {
        let cart_id = $(this).parent().parent().parent().data('cart-id')
        let quantity = parseInt($(this).parent().find('.input-quantity-product').val());
        let max_quantity = parseInt($(this).parent().parent().parent().find(
            '.input-quantity-product').attr(
            'max'));

        if (quantity >= 1 && quantity <= max_quantity) {
            $(this).parent().find('.btn-sub-product').attr('disabled', false);
            if (quantity === max_quantity - 1) {
                quantity++;
                $(this).parent().find('.input-quantity-product').val(quantity);
                $(this).attr('disabled', true);
            } else {
                quantity++;
                $(this).parent().find('.input-quantity-product').val(quantity);
            }
            change_quantity(cart_id, quantity);
        }
    });

    $(document).on('change', '.input-quantity-product', function() {
        console.log("change: " + $(this).val());

        if (parseInt($(this).val()) <= 1) {
            $(this).val(1);
            $(this).parent().find('.btn-sub-product').attr('disabled', false);
        } else if (parseInt($(this).val()) >= parseInt($(this).attr('max'))) {
            $(this).val($(this).attr('max'));
            $(this).parent().find('.btn-add-product').attr('disabled', false);
        }

        let cart_id = $(this).parent().parent().parent().data('cart-id');
        change_quantity(cart_id, $(this).val());
    })

    function change_quantity(cart_id, quantity) {
        $.ajax({
            type: "POST",
            url: "{{URL::to('/update-cart-user') }}",
            data: {
                _token: "{{ csrf_token() }}",
                cart_id,
                quantity
            },
            success: function(data) {
                if (data.status == 200) {
                    get_cart();
                } else if (data.status == 422) {
                    popup_error(data.message);
                } else {
                    console.log(data.message);
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function get_cart() {
        $.ajax({
            type: "GET",
            url: "{{URL::to('/get-cart-user') }}",
            success: function(data) {
                if (data.status == 200) {
                    if (data.data.length > 0) {
                        let total_price_cart = 0;
                        $('.cart-list-product').empty();

                        $('.cart-list-product').append(`
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="col-6 col-lg-7">Sản phẩm</th>
                                        <th class="text-center col-lg-2 col-3 ">Số lượng</th>
                                        <th>Giá</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        `);

                        $.each(data.data, function(key, value) {
                            total_price_cart += parseInt(value.get_product
                                .product_price_discount != 0 ? value.get_product
                                .product_price_discount : value.get_product
                                .product_price * value.quantity);

                            let max_quantity = parseInt(value.get_product
                                .product_quantity -
                                value.get_product.product_sold);
                            $('.cart-list-product  table tbody').append(`
                                    <tr data-cart-id="${value.cart_id}">
                                        <td class="p-2">
                                            <a href="{{URL::to('/chi-tiet-san-pham/${value.get_product.product_slug}') }}">
                                                <div class="cart-product-item-img">
                                                    <img src="{{URL::to('/public/uploads/product/${value.get_product.product_image}') }}">
                                                </div>
                                                <p class="product-name-overflow mt-1 w-75">${value.get_product.product_name}</p>
                                            </a>
                                        </td>
                                        <td class="col-2">
                                            <div class="input-group justify-content-center">
                                                <button class="btn btn-light btn-sm btn-sub-product d-none d-sm-block" style="width: 25px;"  ${ max_quantity == 0 ? 'disabled' : parseInt(value.quantity) == 1 ? 'disabled':''}>-</button>
                                                <input class="text-center form-control form-control-sm input-quantity-product" type="number" value="${ max_quantity == 0 ? 0:parseInt(value.quantity)>max_quantity?max_quantity:value.quantity}" min="1" max="${max_quantity}" style="max-width: 40px;" ${ max_quantity == 0 ? 'disabled':''}>
                                                <button class="btn btn-light btn-sm btn-add-product d-none d-sm-block" style="width: 25px;" ${ max_quantity == 0 ? 'disabled' : parseInt(value.quantity)>=max_quantity?'disabled':''}>+</button>
                                            </div>
                                            ${max_quantity != 0 ?  `<div class="text-success text-center mt-3">Còn: ${max_quantity}</div>`:
                                                '<div class="text-danger text-center mt-3">Hết hàng!</div>'}
                                        </td>
                                        <td>
                                            ${format_currency(value.quantity*value.get_product.product_price_discount!=0?value.quantity*value.get_product.product_price_discount:value.quantity*value.get_product.product_price)}
                                        </td>
                                        <td>
                                            <a type="button" class="btn-delete-cart text-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                `);
                        })

                        $('.total-cart-price').text(format_currency(total_price_cart));
                        $('#order_total').val(total_price_cart);
                    } else {
                        $('.cart-list-product').empty();
                        $('.cart-list-product').append(
                            "<span>Chưa có sản phẩm trong giỏ hàng</span>");
                    }
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function delete_cart(cart_id) {
        $.ajax({
            type: "POST",
            url: "{{URL::to('/delete-cart-user') }}",
            data: {
                _token: "{{ csrf_token() }}",
                cart_id
            },
            success: function(data) {
                if (data.status == 200) {
                    $('#modal-confirm-delete').modal('hide');
                    get_cart();
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
<!-- End script -->