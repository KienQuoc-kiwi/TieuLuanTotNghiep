<?php
session_start();
include('../../config/config.php');
if (isset($_POST['dangnhap'])) {
    $username = $_POST['username'];
    $matkhau = md5($_POST['password']);
    $id_vaitro = $_POST['id_vaitro'];

    // Xác định bảng và cột dựa trên vai trò
    if ($id_vaitro == 1) {
        $table = 'admin';
        $id_column = 'id_admin';
        $name_column = 'ten_admin';
        $sql = "SELECT $id_column, id_vaitro, $name_column FROM $table WHERE username = ? AND password = ? LIMIT 1";
    } elseif ($id_vaitro == 2) {
        $table = 'nhanvien';
        $id_column = 'id_nv';
        $name_column = 'hoten_nhanvien';
        $sql = "SELECT $id_column, id_vaitro, $name_column FROM $table WHERE username = ? AND password = ? LIMIT 1";
    } else {
        $table = 'khachhang';
        $id_column = 'id_khach';
        $name_column = 'ten_khach';
        $sql = "SELECT $id_column, id_vaitro, $name_column FROM $table WHERE username = ? AND password = ? LIMIT 1";
    }

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $matkhau);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $row_data = mysqli_fetch_array($result);
        $_SESSION['id_user'] = $row_data[$id_column];
        $_SESSION['id_vaitro'] = $row_data['id_vaitro'];
        $_SESSION['dangkyk'] = $row_data[$name_column];
        $_SESSION['type_user'] = ($row_data['id_vaitro'] == 1) ? 'admin' : (($row_data['id_vaitro'] == 2) ? 'nhanvien' : 'khachhang');

        // Điều hướng dựa trên vai trò
        if ($_SESSION['id_vaitro'] == 3) {
            // Khách hàng
            header("Location: ../../index.php");
        } else {
            // Admin hoặc Nhân viên
            header("Location: ../../admin/indexad.php");
            if ($_SESSION['id_vaitro'] == 2) {
                $_SESSION['message'] = "Bạn là Nhân viên, không có quyền quản lý nhân viên!";
            }
        }
        exit();
    } else {
        echo '<p style="color:red">Tài khoản hoặc mật khẩu không đúng, vui lòng đăng nhập lại!</p>';
    }
    mysqli_stmt_close($stmt);
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
                <form method="POST">
                    <div class="input-box">
                        <input type="text" placeholder="Tên đăng nhập" required name="username"/>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Mật Khẩu" required name="password"/>
                        <i class="fas fa-lock"></i>
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