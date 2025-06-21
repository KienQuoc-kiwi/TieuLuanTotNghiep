<?php
session_start();
include("../../config/config.php");
if (isset($_POST['dangkyk'])) {
    $ten = $_POST['ten_khach'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    $id_vaitro = $_POST['id_vaitro'];

    // Xác định bảng và cột dựa trên vai trò
    if ($id_vaitro == 1) {
        $table = 'admin';
        $columns = 'ten_admin, username, password, diachi_admin, dienthoai_admin, id_vaitro';
        $stmt = mysqli_prepare($mysqli, "INSERT INTO $table ($columns) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssisi', $ten, $username, $password, $diachi, $dienthoai, $id_vaitro);
    } elseif ($id_vaitro == 2) {
        $table = 'nhanvien';
        $columns = 'hoten_nhanvien, username, password, diachi, sodienthoai, id_vaitro';
        $stmt = mysqli_prepare($mysqli, "INSERT INTO $table ($columns) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssssi', $ten, $username, $password, $diachi, $dienthoai, $id_vaitro);
    } else {
        $table = 'khachhang';
        $columns = 'ten_khach, username, password, diachi, dienthoai, id_vaitro';
        $stmt = mysqli_prepare($mysqli, "INSERT INTO $table ($columns) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssisi', $ten, $username, $password, $diachi, $dienthoai, $id_vaitro);
    }

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo '<p style="color:green">Bạn đã đăng ký thành công</p>';
        $last_id = ($id_vaitro == 1) ? 'id_admin' : (($id_vaitro == 2) ? 'id_nv' : 'id_khach');
        $_SESSION['dangkyk'] = $ten;
        $_SESSION['id_user'] = mysqli_insert_id($mysqli); // Sử dụng id_user chung cho tất cả vai trò
        $_SESSION['id_vaitro'] = $id_vaitro;
        $_SESSION['type_user'] = ($id_vaitro == 1) ? 'admin' : (($id_vaitro == 2) ? 'nhanvien' : 'khachhang');
        header("Location: dangnhapkhach.php");
    } else {
        echo '<p style="color:red">Đăng ký thất bại, vui lòng thử lại!</p>';
    }
    mysqli_stmt_close($stmt);
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
          <div class="input-box">
            <select name="id_vaitro" required style="width: 100%; height: 40px; border-radius: 5px;">
              <?php
              $sql = "SELECT id, ten_vaitro FROM vaitro";
              $result = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['ten_vaitro']) . "</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="login-btn" name="dangkyk">ĐĂNG KÝ</button>
          <a href="dangnhapkhach.php"><p class="or-login">HOẶC ĐĂNG NHẬP NẾU CÓ TÀI KHOẢN</p></a>
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