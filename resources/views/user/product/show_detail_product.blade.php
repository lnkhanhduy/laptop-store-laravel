@extends('layout')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{URL::to('/san-pham')}}">Tất cả sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{\Illuminate\Support\Str::words($product->product_name, 10, '...') }}
            </li>
        </ol>
    </nav>
    <div class="">
        <div class="d-lg-flex">
            <div class="col-lg-5"></div>
            <div class="col-lg-7">
                <h2 class="text-title text-center">Chi tiết sản phẩm</h2>
            </div>
        </div>
        <div class="mt-4 d-lg-flex ">
            <div class="col-lg-7 order-1 order-lg-2 p-3 py-lg-0">
                <h2 style="font-size: 18px;margin-bottom: 10px;font-weight: bold;">
                    {{ $product->product_name }}
                </h2>
                </h2>
                <p style="margin-bottom: 5px;font-weight: bold">
                    Thương hiệu:
                    <span style="font-weight: normal">{{ $product->getBrandName->brand_name }}</span>
                </p>
                <p style="margin-bottom: 16px;font-weight: bold">
                    Tình trạng:
                    <span style="font-weight: normal">{{$product->product_quantity > $product->product_sold ? 'Còn
                            hàng' : 'Hết hàng'}}</span>
                </p>
                @if($product->product_price_discount != 0)
                <span class="card-price">{{number_format(floatval($product->product_price_discount))}} VND</span>
                <br>
                <span class="card-price-old">{{number_format(floatval($product->product_price))}} VND</span>
                <span class="card-price-percent">
                    -{{100 - number_format(floatval($product->product_price_discount) * 100 /
        floatval($product->product_price), 2)}}%
                </span>
                @else
                <span class="card-price">{{number_format(floatval($product->product_price))}} VND</span>
                @endif
                @if($product->product_quantity > $product->product_sold)
                <div class="d-flex mt-3">
                    <button class="btn btn-primary ms-0 ms-lg-2 col-4 btn-add-cart "
                        data-product-id="{{$product->product_id}}">Thêm vào giỏ hàng</button>
                </div>
                @endif
            </div>
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <img src="{{ URL::to('/public/uploads/product/' . $product->product_image) }}" class="w-75 img-main"
                        alt="">
                </div>
                <div class="image-buttons w-100">
                    <div class="image-button active">
                        <img class="max-width-100 img-button"
                            src="{{ URL::to('/public/uploads/product/' . $product->product_image) }}" alt="">
                    </div>
                    @foreach($gallery as $key => $image)
                    <div class="image-button">
                        <img class="max-width-100 img-button"
                            src="{{ URL::to('/public/uploads/gallery/' . $image->gallery_image) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="mt-4 border pb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#detail-product-desc">Mô tả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#detail-product-comment">Bình luận</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content mt-3 px-3">
                <div class="tab-pane container active " id="detail-product-desc">
                    {{ $product->product_desc }}
                </div>
                <div class="tab-pane container fade" id="detail-product-comment">
                    @if(Session::get('user_id') == null)
                    Vui lòng <a href='/dang-nhap' style="color: blue;text-decoration: underline">đăng nhập</a> để
                    bình luận!
                    @else
                    <p style="font-size: 17px;font-weight: bold;margin-top: 10px">Bình luận</p>
                    <form id="form-comment">
                        <div class="form-group mt-2">
                            <textarea class="form-control" id="comment_content"
                                style="resize: none;height: 90px"></textarea>
                            <button type="submit" class="btn btn-outline-primary btn-sm mt-2" style="width: 80px;">
                                Gửi
                            </button>
                        </div>
                    </form>
                    @endif
                    <div id="list-comment">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="text-title">Sản phẩm liên quan</h2>
        <div class="d-md-flex align-items-center justify-content-center mt-4 list-product">
            @foreach($related_product as $key => $related_product_value)
            <div class="list-product-item">
                <div class="card h-100">
                    <a href="{{URL::to('/chi-tiet-san-pham/' . $related_product_value->product_slug)}}" class="h-100">
                        <img src="{{URL::to('/public/uploads/product/' . $related_product_value->product_image)}}"
                            class="card-img-top object-fit-contain p-3" height="170px"
                            alt="{{$related_product_value->product_name}}">
                        <div class="card-body">
                            <h5 class="card-title mb-2" style="height: 45px">
                                {{$related_product_value->product_name}}</h5>
                            {!! $related_product_value->product_price_discount != '0' ?
        "<p class='card-price'>" .
        number_format(floatval($related_product_value->product_price_discount)) . "
                                VND</p>" .
        "<span class='card-price-old'>" .
        number_format(floatval($related_product_value->product_price)) .
        " VND</span>" .
        "<span class='card-price-percent'>-" .
        100 - number_format(floatval($related_product_value->product_price_discount) * 100 /
            floatval($related_product_value->product_price), 2) . "%</span>" :
        "<p class='card-price'>" .
        number_format(floatval($related_product_value->product_price)) . "
                                VND</p>"
                            !!}
                        </div>
                    </a>
                    @if($related_product_value->product_quantity > $related_product_value->product_sold)
                    <div class="card-footer text-center">
                        <button class="btn btn-outline-primary btn-sm btn-add-cart"
                            data-product-id="{{$related_product_value->product_id}}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Thêm vào giỏ hàng</button>
                    </div>
                    @else
                    <div class="card-footer text-center">
                        <button class="btn btn-outline-primary btn-sm" disabled>
                            <i class="fa-solid fa-cart-shopping"></i>
                            Hết hàng</button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    document.title = ("Thông tin sản phẩm - {{$product->product_name}}");
    load_comment();

    let isNotClickViewMoreComment = true;
    let isAddComment = false;
    let dataComment = [];

    $('#form-comment').submit(function(e) {
        e.preventDefault();
        if ($('#comment_content').val().trim() != "") {
            isAddComment = true;
            add_comment();
        }
    })

    $('#gallery-image-detail').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 3,
        slideMargin: 0,
        enableDrag: false,
        currentPagerPosition: 'middle',
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#gallery-image-detail .lslide'
            });
        }
    });

    $(document).on('click', '.btn-view-more-comment', function() {
        let url = $(this).data('url');
        isNotClickViewMoreComment = false;
        load_comment(url);
    })

    function add_comment() {
        $.ajax({
            type: "POST",
            url: "{{URL::to('/add-comment-user')}}",
            data: {
                _token: "{{csrf_token()}}",
                product_id: '{{$product->product_id}}',
                comment_content: $('#comment_content').val()
            },
            success: function(data) {
                if (data.status == 200) {
                    $('#comment_content').val('');
                    load_comment();
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function load_comment(url = "{{URL::to('/load-comment-user')}}") {
        $.ajax({
            type: "GET",
            url,
            data: {
                product_id: '{{$product->product_id}}'
            },
            success: function(data) {
                if (data.status == 200) {
                    if (data.data.data.length == 0) {
                        $('#list-comment').empty();
                        $('#list-comment').append("<p class='mt-3'>Chưa có bình luận.</p>");
                    } else {
                        if (isAddComment) {
                            dataComment = [];
                            isAddComment = false;
                        }

                        $.each(data.data.data, function(key, value) {
                            dataComment.push(value);
                        });

                        if (isNotClickViewMoreComment) {
                            set_data_list_comment(data.data.data, data.data.next_page_url);
                        } else {
                            set_data_list_comment(dataComment, data.data
                                .next_page_url);
                        }
                    }
                }
            }
        })
    }

    function set_data_list_comment(data, next_page_url) {
        $('#list-comment').empty();
        $.each(data, function(key, value) {
            if (value.comment_status == 1) {
                $('#list-comment').append(`
                        <div class="mt-4">
                            <div class="fw-bold">
                                <i class="fa-solid fa-user me-1"></i>
                                ${value.get_user.full_name}
                            </div>
                            <div class="my-2 ms-2">
                                ${value.comment_content}
                            </div>
                            <span class="ms-2" style="font-size: 14px">${formattedTime(value.created_at)}</span>
                        </div>
                        <div class="mt-3 ms-4 reply-comment">
                            <div class="fw-bold">
                                <i class="fa-solid fa-user-gear"></i>
                                Admin
                            </div>
                            <div class="my-2 ms-2">
                            ${value.comment_reply}
                            </div>
                            <span class="ms-2" style="font-size: 14px">${formattedTime(value.updated_at)}</span>
                        </div>
                    `);
            } else {
                $('#list-comment').append(`
                        <div class="mt-4">
                            <div class="fw-bold">
                                <i class="fa-solid fa-user me-1"></i>
                                ${value.get_user.full_name}
                            </div>
                            <div class="my-2 ms-2">
                            ${value.comment_content}
                            </div>
                            <span class="ms-2" style="font-size: 14px">${formattedTime(value.created_at)}</span>
                        </div>
                    `);
            }
        })

        if (next_page_url) {
            $('#list-comment').append(`
                    <div class="mt-3 text-center">
                        <button class="btn btn-sm btn-outline-primary btn-view-more-comment" data-url="${next_page_url}">Xem thêm bình luận</button>
                    </div>
                `);
        }
    }

    $(document).on('click', '.img-button', function() {
        $('.img-main').attr('src', $(this).attr('src'));
        $('.image-button').removeClass('active');
        $(this).parent().addClass('active');
    })
})
</script>
@endsection
<!-- End script -->