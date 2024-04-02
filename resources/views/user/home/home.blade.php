@extends('layout')
@section('content')
<div>
    <div id="carouselHome" class="carousel slide carousel-fade" data-bs-ride="carousel" style="height: 200px">
        <div class="carousel-indicators">
            @foreach($banner as $key => $banner_value)
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="{{$key}}" class="active"
                aria-current="true" aria-label="Slide {{$key}}"></button>
            @endforeach
        </div>
        <div class="carousel-inner h-100">
            @foreach($banner as $key => $banner_value)
            <div class="carousel-item {{$key == 0 ? 'active' : ''}} h-100 d-flex justify-content-center">
                <img src="{{URL::to('/public/uploads/banner/' . $banner_value->banner_image)}}"
                    class="d-block h-100 w-100 object-fit-contain" alt="{{$banner_value->banner_name}}">
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="row mt-5">
        <div class="">
            <h2 class="text-title fs-3 text-center text-sm-start">Sản phẩm mới nhất</h2>
            <div class="list-product mt-4">
                @foreach($new_product as $key => $product)
                <div class="list-product-item">
                    <div class="card h-100">
                        <a href="{{URL::to('/chi-tiet-san-pham/' . $product->product_slug)}}" class="h-100">
                            <img src="{{URL::to('/public/uploads/product/' . $product->product_image)}}"
                                class="card-img-top object-fit-contain p-3" height="170px"
                                alt="{{$product->product_name}}">
                            <div class="card-body">
                                <h5 class="card-title mb-2" style="height: 45px">{{$product->product_name}}</h5>
                                {!! $product->product_price_discount != '0' ?
        "<p class='card-price'>" .
        number_format(floatval($product->product_price_discount)) . " VND</p>" .
        "<span class='card-price-old'>" . number_format(floatval($product->product_price)) .
        " VND</span>" .
        "<span class='card-price-percent'>-" .
        100 - number_format(floatval($product->product_price_discount) * 100 /
            floatval($product->product_price), 2) . "%</span>" :
        "<p class='card-price'>" . number_format(floatval($product->product_price)) . "
                                    VND</p>"
                                !!}
                            </div>
                        </a>
                        @if($product->product_quantity > $product->product_sold)
                        <div class="card-footer text-center">
                            <button class="btn btn-outline-primary btn-sm btn-add-cart"
                                data-product-id="{{$product->product_id}}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Thêm vào giỏ hàng</button>
                        </div>
                        @else
                        <div class="card-footer text-center">
                            <button class="btn btn-outline-primary" disabled>
                                <i class="fa-solid fa-cart-shopping"></i>
                                Hết hàng</button>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{URL::to('/san-pham')}}" class="btn btn-outline-primary">Xem thêm sản phẩm</a>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('.carousel-control-prev-icon').html(`<i class="fa-solid fa-angle-left"></i>`);
    $('.carousel-control-next-icon').html(`<i class="fa-solid fa-angle-right"></i>`);

    if ("{{Session::get('message')}}" != "") {
        popup_success("{{Session::get('message')}}");
        "{{Session::put('message', '')}}";
    }
})
</script>
@endsection
<!-- End script -->