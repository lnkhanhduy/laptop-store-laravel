<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="{{URL::to('/public/user/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/user/css/reset.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/user/css/main.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/user/css/responsive.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/user/css/lightslider.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/user/css/lightgallery.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic">
</head>

<body>
    <!-- Start header -->
    <header>
        <div class="d-flex justify-content-center" style="background-color: #f0f0e9; ">
            <div class="container row">
                <div class="col-6 d-flex align-items-center" style="font-size: 13px">
                    <ul class="list-unstyled d-flex">
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:0123456789">+84 123456789</a>
                        </li>
                        <li class="ms-4">
                            <i class="fa-solid fa-envelope"></i>
                            <a href="mailto:khanhduyhbvl20011@gmail.com">khanhduyhbvl20011@gmail.com</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6">
                    <ul class="list-unstyled d-flex justify-content-end">
                        <li class="header-icon header-icon-facebook">
                            <a href="https://www.facebook.com/lnkhanhduy" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="header-icon header-icon-github">
                            <a href="https://github.com/lnkhanhduy" target="_blank">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </li>
                        <li class="header-icon header-icon-gmail">
                            <a href="mailto:khanhduyhbvl20011@gmail.com" target="_blank">
                                <i class="fa-brands fa-google"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container" style="border-bottom: 1px solid #ccc">
            <div class="row">
                <div class="col-6 d-flex">
                    <a href="{{URL::to('/')}}" class="d-flex align-items-center"
                        style="font-size: 28px;margin-left: 30px;padding:15px 20px;">
                        <i class="fa-solid fa-laptop me-3" style="font-size: 50px;"></i>
                        <span>Laptop Store</span>
                    </a>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                    @if(Session::get('user_id')==null)
                    <div class="user-no-login">
                        <a href="{{URL::to('/dang-nhap')}}" class="btn btn-success">
                            <i class="fa-solid fa-lock"></i>
                            Đăng nhập
                        </a>
                        <a href="{{URL::to('/dang-ky')}}" class="btn btn-primary ms-1">
                            <i class="fa-solid fa-user-plus"></i>
                            Đăng ký
                        </a>
                    </div>
                    @else
                    <div style="font-size: 18px">
                        <div class="dropdown">
                            <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user"></i>
                                Tài khoản
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{URL::to('/lich-su-dat-hang')}}">Lịch sử mua
                                        hàng</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal-change-password">Đổi mật khẩu</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{URL::to('/logout')}}">Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container py-2">
            <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{URL::to('/')}}">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{URL::to('/san-pham')}}">Sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{URL::to('/gio-hang')}}">Giỏ hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{URL::to('/lien-he')}}">Liên hệ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{URL::to('/tin-tuc')}}">Tin tức</a>
                            </li>
                        </ul>
                    </div>
                    <form class="d-flex" role="search" id="search-form" action="{{URL::to('/tim-kiem')}}">
                        @csrf
                        <input class="form-control me-1" type="search" name="search_keyword" id="search_keyword"
                            placeholder="Nhập từ khoá" aria-label="Search">
                        <input class="btn btn-outline-success" type="submit" value="Tìm kiếm">
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <!-- End header -->

    <!-- Start content -->
    <div class="content container">
        <div class="alert-container"></div>
        @yield('content')
        <a id="scroll-to-top" href="#top"><i class="fa fa-angle-up"></i></a>
    </div>
    <!-- End content -->

    <!-- Start footer -->
    <footer style="background-color: #f0f0e9; ">
        <div class="container">
            <div class="row" style="padding: 14px 0 ">
                <div class="col-6 text-center">
                    <a href="https://www.facebook.com/lnkhanhduy" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                        Lê Nguyễn Khánh Duy
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="https://github.com/lnkhanhduy" target="_blank">
                        <i class="fa-brands fa-github"></i>
                        Lê Nguyễn Khánh Duy
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- End footer -->

    <!-- Modal change password -->
    <div class="modal fade" id="modal-change-password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="needs-validation" id="form-change-password" novalidate>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Đổi mật khẩu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="password-change">Mật khẩu mới</label>
                            <input type="password" class="form-control mt-1" id="password-change" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập mật khẩu mới!
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="confirm-password-change">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control mt-1" id="confirm-password-change" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập lại mật khẩu mới!
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End modal change password -->

    <!-- Modal confirm delete -->
    <div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title-confirm-delete"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" id="btn-submit-confirm-delete">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal confirm delete -->

    <!-- start scripts -->
    <script src="{{URL::to('/public/user/js/main.js')}}"></script>
    <script src="{{URL::to('/public/user/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{URL::to('/public/user/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('/public/user/js/lightslider.js')}}"></script>
    <script src="{{URL::to('/public/user/js/lightgallery.js')}}"></script>
    <script src="{{URL::to('/public/user/js/validate-forms.js')}}"></script>
    <script src="{{URL::to('/public/user/js/moment.min.js')}}"></script>
    <script type="text/javascript">
        function show_modal_confirm_delete(title, data_name, data_id, data_class = 'single') {
            $('#modal-title-confirm-delete').text(title);
            $('#btn-submit-confirm-delete').attr(data_name, data_id);
            $('#btn-submit-confirm-delete').attr('data-class', data_class);
            $('#modal-confirm-delete').modal('show');
        }

        $(document).on('submit', '#form-change-password', function(e) {
            e.preventDefault();
            $('#password-change').removeClass('is-invalid');
            $('#confirm-password-change').removeClass('is-invalid');

            let password = $('#password-change').val();
            let confirm_password = $('#confirm-password-change').val();

            if (password != confirm_password) {
                $('#form-change-password').removeClass('was-validated');
                $('#password-change').addClass('is-invalid');
                $('#confirm-password-change').addClass('is-invalid');
                $('#confirm-password-change').next().text('Mật khẩu không trùng khớp!');
            } else if (password.length < 6 || confirm_password.length < 6) {
                $('#form-change-password').removeClass('was-validated');
                $('#password-change').addClass('is-invalid');
                $('#confirm-password-change').addClass('is-invalid');
                $('#confirm-password-change').next().text('Mật khẩu ít nhất 6 kí tự!');
            } else {
                $.ajax({
                    url: "{{URL::to('/change-password-user')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        password
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            $('#modal-change-password').modal('hide');
                            $('#password-change').val('');
                            $('#confirm-password-change').val('');
                            $('#confirm-password-change').next().text(
                                'Vui lòng nhập lại mật khẩu!');
                            show_alert('<i class="fa-solid fa-circle-check"></i>', data.message,
                                'success');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }
        })

        $(document).on('submit', '#search-form', function(e) {
            e.preventDefault();
            if ($('#search_keyword').val() != '') {
                $('#search-form')[0].submit();
            }
        })

        function formattedTime(time) {
            return moment.utc(time).local().format('DD/MM/YYYY HH:mm')
        }

        function set_pagination(data) {
            $('.pagination').empty();
            $('.pagination').append(`
                ${data.current_page != 1 ? `<li class="page-item"><a class="page-link" href="${data.prev_page_url}"><span aria-hidden="true">&laquo;</span></a></li>` : ''}

                ${data.links.slice(1, -1).map(value => `<li class="page-item ${value.active ? 'active' : ''}"><a class="page-link" href="${value.url}">${value.label}</a></li>`).join('')}
                         
                ${data.current_page != data.last_page ? `<li class="page-item"><a class="page-link" href="${data.next_page_url}">  <span aria-hidden="true">&raquo;</span></a></li>` : ''}
            `);
        }

        function format_currency(currency) {
            return parseFloat(currency).toLocaleString('it-IT', {
                style: 'currency',
                currency: 'VND'
            });
        }

        function show_modal_confirm_delete(title, data_name, data_id, data_class = 'single') {
            $('#modal-title-confirm-delete').text(title);
            $('#btn-submit-confirm-delete').attr(data_name, data_id);
            $('#btn-submit-confirm-delete').attr('data-class', data_class);
            $('#modal-confirm-delete').modal('show');
        }

        let isAlertShowing = false;

        function show_alert(icon, message, type) {
            if (isAlertShowing) {
                isAlertShowing = false;
                $('.alert-container').hide();
                $('.alert-container').removeClass('show-animation');
                $('.alert-container').removeClass('hide-animation');
                show_alert(icon, message, type)
                return;
            }

            isAlertShowing = true;

            $('.alert-container').empty();
            $('.alert-container').append(
                `<div class="alert alert-${type} d-flex align-items-center" role="alert">
                    ${icon}
                    <div>${message}</div>
                </div>`
            )

            $('.alert-container').show();
            $('.alert-container').addClass('show-animation');

            setTimeout(function() {
                $('.alert-container').removeClass('show-animation');
                $('.alert-container').addClass('hide-animation');
                setTimeout(function() {
                    $('.alert-container').hide();
                    $('.alert-container').removeClass('hide-animation');
                    isAlertShowing = false;
                }, 1000);
            }, 2500);
        }

        $(document).on('click', '.btn-add-cart', function(e) {
            e.preventDefault();
            if ("{{Session::get('user_id')}}") {
                let product_id = $(this).data('product-id');
                add_cart(product_id);
            } else {
                show_alert('<i class="fa-solid fa-circle-xmark"></i>',
                    'Vui lòng đăng nhập để thêm vào giỏ hàng!', 'danger');
            }
        })

        function add_cart(product_id) {
            $.ajax({
                type: 'POST',
                url: "{{URL::to('/add-cart-user')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    product_id,
                    quantity: 1
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check"></i>', data.message, 'success');
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark"></i>', data.message, 'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    </script>
    @yield('script-sidebar')
    @yield('script')
    <!-- end scripts -->
</body>

</html>