<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Đăng nhập</title>
    <link href="{{URL::to('/public/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/reset.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/main.css')}}" rel="stylesheet">
    <link href="{{URL::to('/public/admin/css/responsive.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class=" d-flex justify-content-center">
        <div class="card" style="width: 400px;margin-top: 100px">
            <div class="card-body">
                <form class="needs-validation" id="form-login-admin" method="POST" action="{{URL::to('/admin/login')}}"
                    novalidate>
                    <h5 class="card-title fs-3 text-uppercase mt-2 fw-bold text-center">Đăng nhập</h5>
                    <div class="form-group">
                        <input type="email" class="form-control mt-4" id="email" name="email" placeholder="Nhập email"
                            required>
                        <span class="invalid-feedback">
                            Vui lòng nhập email!
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control mt-3" id="password" name="password"
                            placeholder="Nhập mật khẩu" required>
                        <span class="invalid-feedback">
                            Vui lòng nhập mật khẩu!
                        </span>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3 px-4">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{URL::to('/public/admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{URL::to('/public/admin/js/validate-forms.js')}}"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#form-login-admin').submit(function(e) {
            e.preventDefault();
            $('#password').next().text('Vui lòng nhập mật khẩu!');
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                if ($('#password').val().length < 6) {
                    $('#form-login-admin').removeClass('was-validated');
                    $('#password').addClass('is-invalid');
                    $('#password').next().text('Mật khẩu ít nhất 6 ký tự!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{URL::to('/admin/login')}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            email: $('#email').val(),
                            password: $('#password').val()
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                window.location.href = "{{URL::to('/admin')}}";
                            } else if (data.status == 422) {
                                $('#form-login-admin').removeClass('was-validated');
                                $('#password').addClass('is-invalid');
                                $('#password').next().text(
                                    data.message);
                            } else {
                                console.log(data);
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    })
                }
            }
        })
    })
    </script>
</body>