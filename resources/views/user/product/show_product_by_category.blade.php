@extends('layout')
@section('content')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item" style="color:#428bca">
                Danh mục sản phẩm
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{$category_product->category_product_name}}
            </li>
        </ol>
    </nav>
    <div class="">
        <div class="d-md-flex align-items-center">
            <h2 class="text-title text-start flex-grow-1 d-flex align-items-center">Sản phẩm theo danh mục</h2>
            <div class="mt-2 mt-md-0">
                <button class="btn btn-sm btn-primary btn-order-by-new btn-order-by ">Mới nhất</button>
                <button class="btn btn-sm btn-outline-primary btn-order-by-sold btn-order-by">Bán chạy</button>
                <button class="btn btn-sm btn-outline-primary btn-order-by-up btn-order-by">
                    <span class="d-none d-sm-inline">Giá tăng dần</span>
                    <span class="d-inline d-sm-none">Giá <i class="fa-solid fa-arrow-up"></i></span>
                </button>
                <button class="btn btn-sm btn-outline-primary btn-order-by-down btn-order-by">
                    <span class="d-none d-sm-inline">Giá giảm dần</span>
                    <span class="d-inline d-sm-none">Giá <i class="fa-solid fa-arrow-down"></i></span>
                </button>
            </div>
        </div>
        <div class="mt-md-4 mt-3 list-product" id="list-product">

        </div>
        <div class="mt-4 d-flex justify-content-end">
            <div class="pagination">

            </div>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    document.title = ("Sản phẩm theo danh mục");

    let data_send = {
        order_by: "new",
        category_product_id: "{{$category_product->category_product_id}}"
    }

    get_product(data_send);

    $(document).on('click', '.btn-order-by-new', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "new",
            category_product_id: "{{$category_product->category_product_id}}"
        }

        get_product(data_send);
    })

    $(document).on('click', '.btn-order-by-sold', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "sold",
            category_product_id: "{{$category_product->category_product_id}}"
        }

        get_product(data_send);
    })

    $(document).on('click', '.btn-order-by-up', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "asc",
            category_product_id: "{{$category_product->category_product_id}}"
        }

        get_product(data_send);
    })

    $(document).on('click', '.btn-order-by-down', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "desc",
            category_product_id: "{{$category_product->category_product_id}}"
        }

        get_product(data_send);
    })

    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');

        get_product(data_send, url);
    })

    function get_product(data, url = "{{URL::to('/get-product-by-category-user')}}") {
        $.ajax({
            type: "GET",
            url,
            data,
            success: function(data) {
                console.log(data.data.data);
                if (data.status == 200 && data.data.data.length > 0) {
                    set_pagination(data.data);
                    $("#list-product").empty();
                    $.each(data.data.data, function(key, value) {
                        $("#list-product").append(`
                                <div class="list-product-item">
                                    <div class="card h-100">
                                        <a href="{{URL::to('/chi-tiet-san-pham/${value.product_slug}')}}" class="h-100">
                                            <img src="{{URL::to('/public/uploads/product/${value.product_image}')}}" 
                                             class="card-img-top object-fit-contain p-3" height="170px" alt="${value.product_name}">
                                        <div class="card-body">
                                            <h5 class="card-title mb-2" style="height: 45px">${value.product_name}</h5>

                                            ${value.product_price_discount != 0?
                                                `<p class='card-price'>
                                                    ${format_currency(value.product_price_discount)} </p>
                                                <span class='card-price-old'>
                                                    ${format_currency(value.product_price)} </span>
                                                <span class='card-price-percent'>-
                                                    ${(100-(value.product_price_discount/value.product_price)*100).toFixed(2)} %</span>`:
                                                `<p class='card-price'>
                                                ${format_currency(value.product_price)} </p>`
                                                }
                                                </div>
                                        </a>
                                        ${value.product_quantity > value.product_sold ?
                                        `<div class="card-footer text-center">
                                            <button class="btn btn-outline-primary btn-sm btn-add-cart"
                                                data-product-id="${value.product_id}">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                Thêm vào giỏ hàng</button>
                                        </div>`: `<div class="card-footer text-center">
                                            <button class="btn btn-outline-primary btn-sm" disabled>
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                Hết hàng</button>
                                        </div>`}
                                    </div>
                                </div>
                            `);
                    })
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