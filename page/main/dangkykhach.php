<?php
session_start();
include("../../config/config.php");
if (isset($_POST['dangkyk'])) {
  $tenkhachhang = $_POST['ten_khach'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $diachi = $_POST['diachi'];
  $dienthoai = $_POST['dienthoai'];
  $sql_dangky = mysqli_query($mysqli, ("INSERT INTO khachhang(ten_khach,username,password,diachi,dienthoai) VALUE(
            '" . $tenkhachhang . "','" . $username . "','" . $password . "','" . $diachi . "','" . $dienthoai . "')"));
  if ($sql_dangky) {
    echo '<p style="color:green">Bạn đã đăng ký thành công</p>';
    $_SESSION['dangkyk'] = $tenkhachhang;
    $_SESSION['id_khach'] = mysqli_insert_id($mysqli);
    header("Location:dangnhapkhach.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ĐĂNG KÝ</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../admin/css/loginkhach.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <div class="main-bg">
    <div class="login-box">
      <h1>ĐĂNG KÝ</h1>
      <div class="login-form">
        <!-- <h2>login Now</h2> -->
        <form method="POST">
          <div class="input-box">
            <input type="text" placeholder="Họ Và Tên" required name="ten_khach" />
            <i class="fa-solid fa-signature"></i>

          </div>
          <div class="input-box">
            <input type="text" placeholder="Tên đăng nhập" required name="username" />
            <i class="fas fa-user"></i>

          </div>
          <div class="input-box">
            <input type="password" placeholder="Mật Khẩu" required name="password" />
            <i class="fas fa-lock"></i>

          </div>
          <div class="input-box">
            <input type="text" placeholder="Địa Chỉ" required name="diachi" />
            <i class="fa-solid fa-address-card"></i>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Số điện thoại" required name="dienthoai" />
            <i class="fa-solid fa-phone"></i>
          </div>
          <!-- <div class="links">
            <a href="#">Forgot Password? <span>Click here</span></a>
            <a href="dangkykhach">New User? <span>Register here</span></a>
          </div> -->
          <button type="submit" class="login-btn" name="dangkyk">REGISTER</button>
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