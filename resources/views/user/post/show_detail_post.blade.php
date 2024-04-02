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
                <li class="breadcrumb-item"><a href="{{URL::to('/tin-tuc')}}"> Tất cả bài viết</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{\Illuminate\Support\Str::words($post->post_title, 10, '...') }}
                </li>
            </ol>
        </nav>
        <div class="">
            <h2 class="text-title mb-4">{{$post->post_title}}</h2>
            <p>{!!$post->post_content!!}</p>

            <div class="mt-5">
                <h2 class="text-title">Bài viết liên quan</h2>
                <div class="mt-4">
                    @foreach ($related_post as $item)
                    <div class="mb-2 border-bottom pb-2 px-2">
                        <a href="{{URL::to('/bai-viet/' . $item->post_slug)}}" class="text-decoration-none">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{URL::to('/public/uploads/post/' . $item->post_image)}}"
                                        class="object-fit-contain w-100" height="120px" alt="">
                                </div>
                                <div class="col-8">
                                    <h5 class="card-title-post mb-2">{{$item->post_title}}</h5>
                                    <p class="card-desc-post mb-2">{{$item->post_desc}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
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
    document.title = ("Bài viết - {{$post->post_title}}");
})
</script>
@endsection
<!-- End script -->