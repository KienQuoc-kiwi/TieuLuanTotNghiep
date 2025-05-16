<?php
session_start();
include('../../config/config.php');
if (isset($_POST['dangnhapad'])) {
    $username = $_POST['username'];
    $matkhau = md5($_POST['password']);
    $sql = "SELECT * FROM admin WHERE username='" . $username . "' AND password='" . $matkhau . "' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $row_data = mysqli_fetch_array($row);
        $_SESSION['dangkyad'] = $row_data['ten_admin'];
        $_SESSION['id_admin'] = $row_data['id_admin'];
        header("Location:../indexad.php");
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
    <link rel="stylesheet" href="../css/loginkhach.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <div class="main-bg">
        <div class="login-box">
            <h1>ĐĂNG NHẬP CHO QUẢN LÝ</h1>
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
                        <a href="#">Quên Mật Khẩu? <span>Click here</span></a>
                        <a href="dangkyadmin.php">Người Dùng Mới? <span>Đăng ký</span></a>
                    </div>
                    <button type="submit" class="login-btn" name="dangnhapad">LOGIN</button>
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