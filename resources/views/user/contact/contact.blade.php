@extends('layout')
@section('content')
<div class="row">
    <div class="col-3">
        @include('user.sidebar.sidebar')
    </div>
    <div class="col-9">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Liên hệ
                </li>
            </ol>
        </nav>
        <div class="container">
            <h2 class="text-title text-start mb-3 ms-2">Liên hệ</h2>
            <div class="card">
                <div class="card-body py-2">
                    <div class="py-2 fs-5">
                        <a href="tel:0123456789">
                            <i class="fa-solid fa-phone"></i>
                            +84 123456789
                        </a>
                    </div>
                    <div class="py-2 fs-5">
                        <a href="mailto:khanhduyhbvl20011@gmail.com" target="_blank">
                            <i class="fa-solid fa-envelope"></i>
                            Lê Nguyễn Khánh Duy
                        </a>
                    </div>
                    <div class="py-2 fs-5">
                        <a href="https://www.facebook.com/lnkhanhduy" target="_blank">
                            <i class="fa-brands fa-facebook"></i>
                            Lê Nguyễn Khánh Duy
                        </a>
                    </div>
                    <div class="py-2 fs-5">
                        <a href="https://github.com/lnkhanhduy" target="_blank">
                            <i class="fa-brands fa-github"></i>
                            Lê Nguyễn Khánh Duy
                        </a>
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
        document.title = ("Liên hệ");
    })
</script>
@endsection
<!-- End script -->