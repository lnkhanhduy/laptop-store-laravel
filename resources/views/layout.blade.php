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
        <div class="px-4 py-2 py-sm-0" style="background-color: #f0f0e9; ">
            <div class="d-flex justify-content-sm-between justify-content-center">
                <div class="d-flex align-items-center" style="font-size: 13px">
                    <ul class="list-unstyled d-flex gap-3">
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:0123456789">+84 123456789</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <a class="email-contact"
                                href="mailto:khanhduyhbvl20011@gmail.com">khanhduyhbvl20011@gmail.com</a>
                            <a class="email-contact-text d-none" href="mailto:khanhduyhbvl20011@gmail.com">Email</a>
                        </li>
                    </ul>
                </div>
                <div class="d-none d-sm-block">
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
        <div class="" style="border-bottom: 1px solid #ccc">
            <div class="d-sm-flex justify-content-between p-2">
                <div class="d-flex justify-content-center align-items-center">
                    <a href="{{URL::to('/trang-chu')}}" class="d-flex align-items-center"
                        style="font-size: 28px;margin-left: 30px;padding:15px 20px;">
                        <i class="fa-solid fa-laptop me-3" style="font-size: 50px;"></i>
                        <span>Laptop Store</span>
                    </a>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    @if(Session::get('user_id') == null)
                    <div class="user-no-login">
                        <a href="{{URL::to('/dang-nhap')}}" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-lock"></i>
                            Đăng nhập
                        </a>
                        <a href="{{URL::to('/dang-ky')}}" class="btn btn-sm btn-primary ms-1">
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
        <div class="py-2">
            <nav class="navbar navbar-expand-lg d-flex justify-content-between px-2 px-sm-4"
                style="background-color: #e3f2fd;">
                <div>
                    <button class="btn btn-light d-block d-lg-none ms-2" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav d-flex align-items-center gap-3">
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/trang-chu') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/trang-chu')}}">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/san-pham') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/san-pham')}}">Sản phẩm</a>
                            </li>
                            <div class="dropdown nav-item ">
                                <a href="#"
                                    class="dropdown-toggle {{Str::contains(Request::url(), '/danh-muc') ? 'active' : ''}}"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">Danh mục</a>
                                <ul class="dropdown-menu category-list">

                                </ul>
                            </div>
                            <div class="dropdown nav-item ">
                                <a href="#"
                                    class="dropdown-toggle {{Str::contains(Request::url(), '/thuong-hieu') ? 'active' : ''}}"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">Thương hiệu</a>
                                <ul class="dropdown-menu brand-list">

                                </ul>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/gio-hang') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/gio-hang')}}">Giỏ hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/lien-he') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/lien-he')}}">Liên hệ</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/tin-tuc') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/tin-tuc')}}">Tin tức</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div>
                    <form class="d-flex" role="search" id="search-form" action="{{URL::to('/tim-kiem')}}">
                        @csrf
                        <input class="form-control me-1" type="search" name="search_keyword" id="search_keyword"
                            placeholder="Nhập từ khoá" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </nav>

            <!-- Offcanvas Menu for smaller screens -->
            <div class="offcanvas offcanvas-start w-auto" tabindex="-1" id="offcanvasMenu"
                aria-labelledby="offcanvasMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasMenuLabel">
                        <a href="{{URL::to('/trang-chu')}}"
                            class="d-flex justify-content-center align-items-center gap-2 me-3">
                            <i class="fa-solid fa-laptop" style="font-size: 20px;"></i>
                            <span>Laptop Store</span>
                        </a>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <nav class="d-flex d-lg-none flex-column gap-2">
                        <ul class="navbar-nav d-flex gap-2">
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/trang-chu') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/trang-chu')}}">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/san-pham') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/san-pham')}}">Sản phẩm</a>
                            </li>
                            <div>
                                <p class="d-inline-flex">
                                    <a href="#"
                                        class="nav-link dropdown-toggle {{Str::contains(Request::url(), '/danh-muc') ? 'active' : ''}}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#category_list_collapse"
                                        aria-expanded="false" aria-controls="category_list_collapse">Danh mục</a>
                                </p>
                                <div class="collapse" id="category_list_collapse">

                                </div>
                            </div>

                            <div>
                                <p class="d-inline-flex">
                                    <a href="#"
                                        class="nav-link dropdown-toggle {{Str::contains(Request::url(), '/thuong-hieu') ? 'active' : ''}}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#brand_list_collapse"
                                        aria-expanded="false" aria-controls="brand_list_collapse">Thương hiệu</a>
                                </p>
                                <div class="collapse" id="brand_list_collapse">

                                </div>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/gio-hang') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/gio-hang')}}">Giỏ hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/lien-he') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/lien-he')}}">Liên hệ</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link {{Str::contains(Request::url(), '/tin-tuc') ? 'active' : ''}}"
                                    aria-current="page" href="{{URL::to('/tin-tuc')}}">Tin tức</a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- End header -->

    <!-- Start content -->
    <div class="content ">
        @yield('content')
        <a id="scroll-to-top" href="#top"><i class="fa fa-angle-up"></i></a>
    </div>
    <!-- End content -->

    <!-- Start footer -->
    <footer style="background-color: #f0f0e9; ">
        <div class="d-flex p-3 justify-content-around align-items-center">
            <div class="text-center">
                <a href="https://www.facebook.com/lnkhanhduy" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                    <span class="d-sm-inline d-none">Lê Nguyễn Khánh Duy</span>
                    <span class="d-inline d-sm-none">Khánh Duy</span>
                </a>
            </div>
            <div class="text-center">
                <a href="https://github.com/lnkhanhduy" target="_blank">
                    <i class="fa-brands fa-github"></i>
                    <span class="d-sm-inline d-none">Lê Nguyễn Khánh Duy</span>
                    <span class="d-inline d-sm-none">Khánh Duy</span>
                </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function show_modal_confirm_delete(title, data_name, data_id, data_class = 'single') {
        $('#modal-title-confirm-delete').text(title);
        $('#btn-submit-confirm-delete').attr(data_name, data_id);
        $('#btn-submit-confirm-delete').attr('data-class', data_class);
        $('#modal-confirm-delete').modal('show');
    }

    function popup_success(title) {
        return Swal.fire({
            title: title,
            timer: 3000,
            timerProgressBar: true,
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: "Đóng",
        })
    }

    function popup_error(title) {
        return Swal.fire({
            title: title,
            timer: 3000,
            timerProgressBar: true,
            icon: 'error',
            showConfirmButton: true,
            confirmButtonText: "Đóng",
        })
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
                        popup_success(data.message);
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


    $(document).on('click', '.btn-add-cart', function(e) {
        e.preventDefault();
        if ("{{Session::get('user_id')}}") {
            let product_id = $(this).data('product-id');
            add_cart(product_id);
        } else {
            popup_error('Vui lòng đăng nhập để thêm vào giỏ hàng!')
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
                    popup_success(data.message);
                } else {
                    popup_error(data.message);
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: "{{URL::to('/load-category-product-user')}}",
            success: function(data) {
                if (data.status == 200) {
                    $('.category-list').empty();
                    $('#category_list_collapse').empty();
                    data.data.forEach(element => {
                        $('.category-list').append(`
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::to('/danh-muc-san-pham/${element.category_product_slug}')}}">${element.category_product_name}</a>
                            </li>
                        `)
                        $('#category_list_collapse').append(`
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::to('/danh-muc-san-pham/${element.category_product_slug}')}}">${element.category_product_name}</a>
                            </li>
                        `)
                    })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            type: 'GET',
            url: "{{URL::to('/load-brand-user')}}",
            success: function(data) {
                if (data.status == 200) {
                    $('.brand-list').empty();
                    $('#brand_list_collapse').empty();
                    data.data.forEach(element => {
                        $('.brand-list').append(`
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::to('/thuong-hieu-san-pham/${element.brand_slug}')}}">${element.brand_name}</a>
                            </li>
                        `)

                        $('#brand_list_collapse').append(`
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::to('/thuong-hieu-san-pham/${element.brand_slug}')}}">${element.brand_name}</a>
                            </li>
                        `)
                    })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    })
    </script>
    @yield('script-sidebar')
    @yield('script')
    <!-- end scripts -->
</body>

</html>