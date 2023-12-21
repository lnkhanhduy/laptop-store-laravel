@extends('layout')
@section('content')
<div class="d-flex justify-content-center">
    <div class="card" style="width: 500px;">
        <div class="card-body">
            <h2 class="text-center form-title" style="font-size: 24px; margin-bottom: 20px;">Đăng nhập</h2>
            <form class="needs-validation" id="form-action" data-action="login" novalidate
                action="{{URL::to('/login')}}" method="POST">
                @csrf

            </form>
            <div class="mt-3">
                <p class="text-center">Hoặc</p>
                <div class="d-flex justify-content-center mt-2">
                    <a href="{{URL::to('/login-facebook')}}" class="btn btn-primary me-2">
                        <i class="fa-brands fa-facebook"></i>
                        Đăng nhập với Facebook</a>
                    <a href="{{URL::to('/login-google')}}" class="btn btn-danger">
                        <i class="fa-brands fa-google"></i>
                        Đăng nhập với Google</a>
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
        if (window.location.href == "{{URL::to('/dang-nhap')}}") {
            document.title = 'Đăng nhập';
            load_form_login();
        } else if (window.location.href == "{{URL::to('/dang-ky')}}") {
            document.title = 'Đăng ký';
            load_form_register();
        }

        $(document).on('click', '.btn-login-form-register', function() {
            load_form_login();
        });

        $(document).on('click', '.btn-register-form-login', function() {
            load_form_register();
        });

        $(document).on('submit', '#form-action', function(e) {
            e.preventDefault();
            $('#password-login').removeClass('is-invalid');
            $('#password-register').removeClass('is-invalid');
            $('#confirm-password-register').removeClass('is-invalid');
            $('#confirm-password-register').next().text('Vui lòng nhập lại mật khẩu!');
            $('#password-login').next().text('Vui lòng nhập mật khẩu!');
            $('#email-login').next().text('Vui lòng nhập email!');

            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                if ($(this).attr('data-action') == 'register' && $('#password-register').val() != $(
                        '#confirm-password-register').val()) {
                    $('#form-action').removeClass('was-validated');
                    $('#password-register').addClass('is-invalid');
                    $('#confirm-password-register').addClass('is-invalid');
                    $('#confirm-password-register').next().text('Mật khẩu không trùng khớp!');
                } else if ($(this).attr('data-action') == 'register' && ($('#password-register').val()
                        .length < 6 || $('#confirm-password-register').val().length < 6)) {
                    $('#form-action').removeClass('was-validated');
                    $('#password-register').addClass('is-invalid');
                    $('#confirm-password-register').addClass('is-invalid');
                    $('#confirm-password-register').next().text('Mật khẩu ít nhất 6 ký tự!')
                } else if ($(this).attr('data-action') == 'login' && $('#password-login').val().length <
                    6) {
                    $('#form-action').removeClass('was-validated');
                    $('#password-login').addClass('is-invalid');
                    $('#password-login').next().text('Mật khẩu ít nhất 6 ký tự!')
                }

                if ($('#form-action').data('action') == 'login') {
                    login_account();
                } else {
                    register_account();
                }
            }
        });

        function load_form_login() {
            $('#form-action').removeClass('was-validated');
            $('.form-title').text('Đăng nhập');
            $('#form-action').empty();
            $('#form-action').attr('data-action', 'login');
            $('#form-action').attr('action', "{{URL::to('/login')}}");
            $('#form-action').append(`
                <div class="form-group">
                    <label for="email-login">Email</label>
                    <input type="email-login" class="form-control mt-1" id="email-login" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập đúng định dạng email!
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="password-login">Mật khẩu</label>
                    <input type="password" class="form-control mt-1" id="password-login" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập mật khẩu!
                    </div>
                </div>
                <div class="error mt-2 text-danger d-none">
                    Sai email hoặc mật khẩu!
                </div>
                <div class="mt-3 text-end">
                    <a href="{{URL::to('/quen-mat-khau')}}" class="text-decoration-underline">Quên mật khẩu?</a>
                </div>
                <div class="mt-3 text-end">
                    <span>Bạn chưa có tài khoản?</span>
                    <a type="button" class="text-decoration-underline btn-register-form-login">Đăng ký</a>
                </div>

                <button type="submit" class="btn btn-success mt-3 w-100">Đăng nhập</button>
            `);
        }

        function load_form_register() {
            $('#form-action').removeClass('was-validated');
            $('.form-title').text('Đăng ký');
            $('#form-action').empty();
            $('#form-action').attr('data-action', 'register');
            $('#form-action').attr('action', "{{URL::to('/register')}}");
            $('#form-action').append(`
                <div class="form-group">
                    <label for="name-register">Họ và tên</label>
                    <input type="name-register" class="form-control mt-1" id="name-register" name="name_register"required>
                    <div class="invalid-feedback">
                        Vui lòng nhập tên!
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="email-register">Email</label>
                    <input type="email-register" class="form-control mt-1" id="email-register" name="email_register" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập đúng định dạng email!
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="password-register">Mật khẩu</label>
                    <input type="password" class="form-control mt-1" id="password-register" name="password_register" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập mật khẩu!
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="confirm-password-register">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control mt-1" id="confirm-password-register" name="confirm_password_register" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập lại mật khẩu!
                    </div>
                </div>
                <div class="error mt-2 text-danger d-none">
                    Email đã được sử dụng!
                </div>
                <div class="mt-3 text-end">
                    <span>Bạn đã có tài khoản?</span>
                    <a type="button" class="text-decoration-underline btn-login-form-register">Đăng nhập</a>
                </div>

                <button type="submit" class="btn btn-success mt-3 w-100">Đăng ký</button>
            `);
        }

        function login_account() {
            let email_login = $('#email-login').val();
            let password_login = $('#password-login').val();

            $.ajax({
                url: "{{URL::to('/login')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email_login,
                    password_login,
                },
                success: function(data) {
                    if (data.status == 200) {
                        window.location.href = "{{URL::to('/')}}";
                    } else if (data.status == 400) {
                        $('#form-action').removeClass('was-validated');
                        $('#email-login').addClass('is-invalid');
                        $('#email-login').next().text('');
                        $('#password-login').addClass('is-invalid');
                        $('#password-login').next().text('');
                        $('.error').removeClass('d-none');
                    } else {
                        console.log(data.message);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        function register_account() {
            let name_register = $('#name-register').val();
            let email_register = $('#email-register').val();
            let password_register = $('#password-register').val();
            let confirm_password_register = $('#confirm-password-register').val();

            $.ajax({
                url: "{{URL::to('/register')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name_register,
                    email_register,
                    password_register,
                    confirm_password_register,
                },
                success: function(data) {
                    if (data.status == 200) {
                        window.location.href = "{{URL::to('/')}}";
                    } else {
                        console.log(data.message);
                    }
                },
                error: function(data) {
                    if (data.status == 422 && data.responseJSON.errors.email_register) {
                        $('#form-action').removeClass('was-validated');
                        $('#email-register').addClass('is-invalid');
                        $('.error').removeClass('d-none');
                    } else {
                        console.log(data);
                    }
                }
            })
        };
    });
</script>
@endsection
<!-- End script -->