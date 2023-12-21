@extends('layout')
@section('content')
<div class="d-flex justify-content-center">
    <div class="card" style="width: 500px;">
        <div class="card-body">
            <h2 class="text-center form-title" style="font-size: 24px; margin-bottom: 15px;">Quên mật khẩu</h2>
            <form class="needs-validation" id="forgot-form" novalidate>
                <div class="alert alert-primary">Vui lòng nhập email đã đăng ký để đặt lại mật khẩu!</div>
                <div class="input-group">
                    <input class="form-control" id="forgot-email" type="email" name="email" placeholder="Nhập email"
                        required>
                    <button type="submit" class="btn btn-primary"
                        style="border-top-right-radius: var(--bs-border-radius);border-bottom-right-radius: var(--bs-border-radius);">
                        Gửi mã</button>
                    <div class="invalid-feedback">
                        Vui lòng nhập email!
                    </div>
                </div>
            </form>

            <form class="needs-validation mt-4 d-none" id="reset-form" novalidate>
                <div class="alert alert-success">Chúng tôi đã gửi mã xác nhận qua địa chỉ email của bạn. Vui lòng nhập
                    mã xác nhận để đặt lại mật khẩu!</div>
                <div class="input-group">
                    <input class="form-control" id="reset-code" type="text" name="reset_code"
                        placeholder="Nhập mã xác nhận" required>
                    <button type="submit" class="btn btn-primary"
                        style="border-top-right-radius: var(--bs-border-radius);border-bottom-right-radius: var(--bs-border-radius);">
                        Xác nhận</button>
                    <div class="invalid-feedback">
                        Vui lòng nhập mã xác nhận!
                    </div>
                </div>
            </form>

            <div class="alert alert-success d-none" id="alert-reset-password-success">Đặt lại mật khẩu thành công,
                <a href="{{URL::to('/dang-nhap')}}" style="color: blue;text-decoration: underline">đăng nhập ngay.</a>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Start script -->
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = 'Quên mật khẩu';
        let email = '';
        $('#forgot-form').submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                $.ajax({
                    url: "{{URL::to('/forgot-password')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $('#forgot-email').val(),
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            $('#forgot-form').addClass('d-none');
                            $('#reset-form').removeClass('d-none');
                            email = $('#forgot-email').val();
                        } else {
                            console.log(data.message);
                        }
                    },
                    error: function(data) {
                        if (data.status == 422 && data.responseJSON.errors.email) {
                            $('#form-action').removeClass('was-validated');
                            $('#forgot-email').addClass('is-invalid');
                            $('#forgot-email').next().next().text(data.responseJSON.errors
                                .email[
                                    0]);
                        } else {
                            console.log(data.message);
                        }
                    }
                })
            }
        });

        $('#reset-form').submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                $.ajax({
                    url: "{{URL::to('/reset-password')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email,
                        reset_code: $('#reset-code').val(),
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            $('#reset-form').addClass('d-none');
                            $('#alert-reset-password-success').removeClass('d-none');
                        } else if (data.status == 422) {
                            $('#reset-form').removeClass('was-validated');
                            $('#reset-code').addClass('is-invalid');
                            $('#reset-code').next().next().text(data.message);
                        } else {
                            console.log(data.message);
                        }
                    },
                    error: function(data) {
                        if (data.status == 422 && data.responseJSON.errors.reset_code) {
                            $('#form-action').removeClass('was-validated');
                            $('#reset-code').addClass('is-invalid');
                            $('#reset-code').next().next().text(data.responseJSON.errors
                                .reset_code[0]);
                        } else {
                            console.log(data.message);
                        }
                    }
                })
            }
        });
    })
</script>
@endsection
<!-- End script -->