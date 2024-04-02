@extends('layout')
@section('content')
<div class="row">
    <div class="col-3">
        @include('user.sidebar.sidebar')
    </div>
    <div class="col-9">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tin tức
                </li>
            </ol>
        </nav>
        <div class="">
            <div class="d-flex align-items-center">
                <h2 class="text-title text-start flex-grow-1 d-flex align-items-center">Tất cả bài viết</h2>
                <div>
                    <button class="btn btn-sm btn-primary btn-order-by-new btn-order-by ms-3 ">Mới nhất</button>
                    <button class="btn btn-sm btn-outline-primary btn-order-by-most-view btn-order-by">Nổi bật</button>
                </div>
            </div>
            <div class="mt-3">
                <div class="card">
                    <div class="card-body" id="list-post">

                    </div>
                    <div class="card-footer">
                        <div class="mt-4 d-flex justify-content-end">
                            <div class="pagination">

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
    document.title = ("Tin tức");

    let data_send = {
        order_by: "new",
    }

    get_product(data_send);

    $(document).on('click', '.btn-order-by-new', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "new",
        }

        get_product(data_send);
    })

    $(document).on('click', '.btn-order-by-most-view', function() {
        $('.btn-order-by').removeClass('btn-primary');
        $('.btn-order-by').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary');
        data_send = {
            order_by: "view",
        }

        get_product(data_send);
    })

    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');

        get_product(data_send, url);
    })

    function get_product(data, url = "{{URL::to('/get-all-post-user')}}") {
        $.ajax({
            type: "GET",
            url,
            data,
            success: function(data) {
                if (data.status == 200 && data.data.data.length > 0) {
                    set_pagination(data.data);
                    $("#list-post").empty();
                    $.each(data.data.data, function(key, value) {
                        $("#list-post").append(`
                                <div class="mb-2 border-bottom pb-2 px-2">
                                    <a href="{{URL::to('/bai-viet/${value.post_slug}')}}" class="text-decoration-none">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{URL::to('/public/uploads/post/${value.post_image}')}}"
                                                    class="object-fit-contain w-100" height="120px" alt="${value.post_title}">
                                            </div>
                                            <div class="col-8">
                                                <h5 class="card-title-post mb-2">${value.post_title}</h5>
                                                <p class="card-desc-post mb-2">${value.post_desc}</p>
                                            </div>
                                        </div>
                                    </a>
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