<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="{{URL::to('/public/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/reset.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/main.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/responsive.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic">
    <script src="{{URL::to('/public/admin/js/ckeditor/ckeditor.js')}}"></script>
</head>

<body>
    <!-- start container -->
    <div class="container-fluid p-0">
        <!-- <div class="container-layout"> -->
        <!-- start sidebar-->
        <div class="sidebar-container col-xxl-2 col-lg-3 col-sm-4 ">
            <div class="sidebar-header">
                <a href="{{URL::to('/admin')}}">Laptop Store</a>
                <button class="btn btn-primary toggle-sidebar-panel" type="button" data-bs-toggle="collapse"
                    data-bs-target="#toggle-sidebar-panel">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div class="show collapse-horizontal" id="toggle-sidebar-panel">
                <div class="sidebar-menu">
                    <ul class="accordion" id="sidebar-menu">
                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin')}}" class="btn-accordion-button accordion-button collapsed"
                                    type="button" data-bs-target="#statistical-accordion">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <span>Thống kê</span>
                                </a>
                                <div id="statistical-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/banner')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#banner-accordion">
                                    <i class="fa-solid fa-flag"></i>
                                    <span>Banner</span>
                                </a>
                                <div id="banner-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/brand')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#brand-accordion">
                                    <i class="fa-solid fa-building"></i>
                                    <span>Thương hiệu sản phẩm</span>
                                </a>
                                <div id="brand-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/category-product')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#brand-accordion">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>Danh mục sản phẩm</span>
                                </a>
                                <div id="brand-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>


                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/product')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#product-accordion">
                                    <i class="fa-solid fa-box"></i>
                                    <span>Sản phẩm</span>
                                </a>
                                <div id="product-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/voucher')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#voucher-accordion">
                                    <i class="fa-solid fa-percent"></i>
                                    <span>Mã giảm giá</span>
                                </a>
                                <div id="voucher-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/order')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#order-accordion">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span>Đơn hàng</span>
                                </a>
                                <div id="order-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/category-post')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#category-post-accordion">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>Danh mục bài viết</span>
                                </a>
                                <div id="category-post-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/post')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#post-accordion">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <span>Bài viết</span>
                                </a>
                                <div id="post-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{URL::to('/admin/comment')}}"
                                    class="btn-accordion-button accordion-button collapsed" type="button"
                                    data-bs-target="#comment-accordion">
                                    <i class="fa-solid fa-comment"></i>
                                    <span>Bình luận</span>
                                </a>
                                <div id="comment-accordion" class="collapse" data-bs-parent="#sidebar-menu">
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="sidebar-footer">
                    <div class="btn-group dropup">
                        <a type="button" class="dropdown-toggle position-relative" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="d-flex align-items-center justify-content-center text-white">
                                <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                                    class="rounded-circle me-2">
                                <strong>Xin chào, {{Session::get('admin_name')}}</strong>
                            </div>
                        </a>
                        <ul class="dropdown-menu text-dark">
                            <li>
                                <a class="dropdown-item" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal-change-password">
                                    Đổi mật khẩu
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{URL::to('/admin/logout')}}">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end sidebar -->
        <!-- start content -->
        <div class="content col-xxl-10 col-lg-9 col-sm-8">
            <div class="alert-container"></div>
            @yield('admin_content')
        </div>
        <!-- end content -->

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
    </div>
    <!-- end container -->

    <!-- start scripts -->
    <script src="{{URL::to('/public/admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/validate-forms.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/moment.min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/raphael-min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/morris.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/main.js')}}"></script>
    @yield('admin_script')
    <!-- end scripts -->
</body>

</html>