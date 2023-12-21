<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gửi mail</title>
    <link href="{{URL::to('/public/user/css/bootstrap.min.css')}}" rel="stylesheet">
</head>

<body>
    <p>Xin chào, {{ $name }}!</p>
    <p>Đây là mã xác nhận của bạn: <span class="fw-bold text-success">{{ $code }}</span></p>
    <p>Sau khi nhập mã xác nhận thành công mật khẩu của bạn sẽ đặt lại thành:
        <span class="fw-bold text-success">123456</span>
    </p>
    <p class="fw-bold text-warning">Lưu ý: Mã xác nhận có hiệu lực trong 5 phút!</p>
</body>

</html>