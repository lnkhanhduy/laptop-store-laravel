@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav>
    <div class="container">
        <h2 class="text-title text-start mb-3 ms-2">Giỏ hàng</h2>


        <div class="card">
            <div class="card-header border-bottom py-3" style="font-size: 16px;">
                <div class="col-5 fw-bold ps-3">Sản phẩm</div>
                <div class="col-2 text-center fw-bold">Đơn giá</div>
                <div class="col-2 text-center fw-bold">Số lượng</div>
                <div class="col-2 text-end fw-bold">Thành tiền</div>
                <div class="col-1"></div>
            </div>
            <div class="card-body" id="list-cart">

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
            show_modal_confirm_delete('Bạn muốn xóa giỏ hàng này', 'data-cart-id',
                cart_id);
        });

        $('#btn-submit-confirm-delete').click(function() {
            let cart_id = $(this).attr('data-cart-id');
            delete_cart(cart_id);
        })

        $(document).on('submit', '#form-cart-to-checkout', function(e) {
            e.preventDefault();
            let data_cart_id = $('#data-cart-id').val();
            if (data_cart_id) {
                $('#form-cart-to-checkout')[0].submit();
            }
        })

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
                        show_alert('<i class="fa-solid fa-circle-xmark"></i>', data.message,
                            'danger');
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
                            let data_cart_id = [];
                            total_price_cart = 0;
                            $('#list-cart').empty();
                            $.each(data.data, function(key, value) {
                                if (value.quantity > 0 && value.get_product
                                    .product_quantity > value.get_product.product_sold) {
                                    data_cart_id.push(value.cart_id);
                                }

                                total_price_cart += parseInt(value.get_product
                                    .product_price_discount != 0 ? value.get_product
                                    .product_price_discount : value.get_product
                                    .product_price * value.quantity);

                                let max_quantity = parseInt(value.get_product
                                    .product_quantity -
                                    value.get_product.product_sold);
                                $('#list-cart').append(`
                                    <div class="d-flex border-bottom mt-2 pb-2" data-cart-id="${value.cart_id}">
                                        <div class="col-5 d-flex">
                                            <div class="col-4">
                                                <img src="{{URL::to('/public/uploads/product/${value.get_product.product_image}') }}"
                                                    style="width: 100%; height: 90px; object-fit: cover">
                                            </div>
                                            <div class="col-8 ps-3">
                                                <p class="card-title mt-1">${value.get_product.product_name}</p>
                                            </div>
                                        </div>
                                        <div class="col-2 text-center mt-1">
                                            ${format_currency(value.get_product.product_price_discount!=0?value.get_product.product_price_discount:value.get_product.product_price)}
                                            </div>
                                        <div class="col-2">
                                            <div class="input-group justify-content-center">
                                                <button class="btn btn-light btn-sm btn-sub-product" style="width: 25px;"  ${ max_quantity == 0 ? 'disabled' : parseInt(value.quantity) == 1 ? 'disabled':''}>-</button>
                                                <input class="text-center form-control input-quantity-product" type="number" value="${ max_quantity == 0 ? 0:parseInt(value.quantity)>max_quantity?max_quantity:value.quantity}" min="1" max="${max_quantity}" style="width: 60px; flex: none;" ${ max_quantity == 0 ? 'disabled':''}>
                                                <button class="btn btn-light btn-sm btn-add-product" style="width: 25px;" ${ max_quantity == 0 ? 'disabled' : parseInt(value.quantity)>=max_quantity?'disabled':''}>+</button>
                                            </div>
                                            ${max_quantity != 0 ?  `<div class="text-success text-center mt-3">Còn: ${max_quantity}</div>`:
                                                '<div class="text-danger text-center mt-3">Hết hàng!</div>'}
                                        </div>
                                        <div class="col-2 mt-1 text-end">
                                            ${format_currency(value.quantity*value.get_product.product_price_discount!=0?value.quantity*value.get_product.product_price_discount:value.quantity*value.get_product.product_price)}
                                        </div>
                                        <div class="col-1 mt-1 text-danger text-end ">
                                            <a type="button" class="btn-delete-cart"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </div>
                                `);
                            })

                            $('#list-cart').append(`  
                                <div class="card-footer mt-3 d-flex align-items-center justify-content-end">
                                    <form action="{{URL::to('/thanh-toan')}}" method="POST" id="form-cart-to-checkout">
                                        @csrf
                                        <input type="hidden" name="data_cart_id" value="${data_cart_id}" id="data-cart-id" required/>
                                        <span class="fw-bold" style="font-size: 18px">Tổng tiền: &nbsp;</span>
                                        <span class="fw-bold" style="color: blue; font-size: 18px">${format_currency(total_price_cart)}</span>
                                        <button type="submit" class="btn btn-primary ms-5">Thanh toán</button>     
                                    </form>
                                </div>
                            `)
                        } else {
                            $('#list-cart').empty();
                            $('#list-cart').append(
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
                        show_alert('<i class="fa-solid fa-circle-check"></i>', data.message,
                            'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_cart();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark"></i>', data.message,
                            'danger');
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