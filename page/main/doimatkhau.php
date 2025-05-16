<?php
//session_start();
include('../../config/config.php');
if (isset($_POST['thaydoi'])) {
    $email = $_POST['username'];
    $matkhau_cu = md5($_POST['password_cu']);
    $matkhau_moi = md5($_POST['password_moi']);
    $sql = "SELECT * FROM khachhang WHERE username='" . $email . "' AND password='" . $matkhau_cu . "' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $sql_update = mysqli_query($mysqli, "UPDATE khachhang SET password='" . $matkhau_moi . "'");
        echo 'Mật khẩu đã được thay đổi';
    } else {
        echo 'Tài khoản hoặc mật khẩu cũ không đúng, vui lòng đăng nhập lại!';
        // header("Location:login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ĐỔI MẬT KHẨU</title>
    <link rel="stylesheet" href="../../admin/css/loginkhach.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <div class="main-bg">
        <div class="login-box">
            <h1>ĐỔI MẬT KHẨU</h1>
            <div class="login-form">
                <form method="POST">
                    <div class="input-box">
                        <input type="text" placeholder="Username..." required name="username" />
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Mật khẩu cũ..." required name="password_cu" />
                        <i class="fas fa-lock"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Mật khẩu mới..." required name="password_moi" />
                        <i class="fas fa-key"></i>
                    </div>

                    <button type="submit" class="login-btn" name="thaydoi">THAY ĐỔI PASSWORD</button>

                    <div class="danhnhap"><a href="dangnhapkhach.php">Đăng nhập</a></div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>