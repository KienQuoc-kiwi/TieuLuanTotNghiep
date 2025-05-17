<?php
session_start();
include('../../config/config.php');
if (isset($_POST['dangnhap'])) {
    $username = $_POST['username'];
    $matkhau = md5($_POST['password']);
    $sql = "SELECT * FROM khachhang WHERE username='" . $username . "' AND password='" . $matkhau . "' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $row_data = mysqli_fetch_array($row);
        $_SESSION['dangkyk'] = $row_data['ten_khach'];
        $_SESSION['id_khach'] = $row_data['id_khach'];
        header("Location:../../index.php");
    } else {
        // header("Location:dangnhap.php");
        echo 'Tài khoản hoặc mật khẩu không đúng, vui lòng đăng nhập lại!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ĐĂNG NHẬP</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../../admin/css/loginkhach.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <div class="main-bg">
        <div class="login-box">
            <h1>ĐĂNG NHẬP</h1>
            <div class="login-form">
                <!-- <h2>login Now</h2> -->
                <form method="POST">
                    <div class="input-box">
                        <input type="text" placeholder="Tên đăng nhập" required name="username"/>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Mật Khẩu" required name="password"/>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="links">
                        <a href="doimatkhau.php">Quên Mật Khẩu? <span>Click here</span></a>
                        <a href="dangkykhach.php">Người Dùng Mới? <span>Đăng ký</span></a>
                    </div>
                    <button type="submit" class="login-btn" name="dangnhap">LOGIN</button>
                    <p class="or-login">Or Login with</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </form>
            </div>
            <footer>
                <p>© 2017 Clean Login Form . All rights reserved | Design by <a href="#">W3layouts</a></p>
            </footer>
        </div>
    </div>
</body>

</html>