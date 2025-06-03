<p>Thanh toán</p>
<?php
session_start();
include("../../config/config.php");

// Kiểm tra đăng nhập và giỏ hàng
if (!isset($_SESSION['id_khach']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p style='color:red;'>Lỗi: Bạn chưa đăng nhập hoặc giỏ hàng trống.</p>";
    exit;
}

$id_khach = $_SESSION['id_khach'];
$ma_giohang = 'DH' . time(); // Mã đơn hàng duy nhất
$ngaytao = date('Y-m-d H:i:s');
$trangthai = 'Chờ xác nhận';

// Kiểm tra tồn kho trước khi tạo đơn
$loi_tonkho = false;
foreach ($_SESSION['cart'] as $item) {
    $id_sanpham = $item['id'];
    $soluong = $item['soluong'];

    $sql_check = "SELECT soluong FROM sanpham WHERE id_sanpham = $id_sanpham";
    $result_check = mysqli_query($mysqli, $sql_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if (!$row_check || $row_check['soluong'] < $soluong) {
        echo "<p style='color:red;'>❌ Sản phẩm ID $id_sanpham không đủ hàng trong kho.</p>";
        $loi_tonkho = true;
    }
}

if ($loi_tonkho) {
    echo "<p><a href='../../index.php'>⬅️ Quay lại giỏ hàng</a></p>";
    exit;
}

// 1. Tạo đơn hàng
$sql_donhang = "INSERT INTO donhang(ma_giohang, id_khach, ngaytao, trangthai) 
                VALUES ('$ma_giohang', '$id_khach', '$ngaytao', '$trangthai')";
$query_donhang = mysqli_query($mysqli, $sql_donhang);

if (!$query_donhang) {
    echo "<p style='color:red;'>Lỗi khi tạo đơn hàng: " . mysqli_error($mysqli) . "</p>";
    exit;
}

// 2. Duyệt giỏ hàng để trừ kho và lưu chi tiết
foreach ($_SESSION['cart'] as $item) {
    $id_sanpham = $item['id'];
    $soluong = $item['soluong'];

    // Trừ tồn kho
    $update_kho = "UPDATE sanpham SET soluong = soluong - $soluong WHERE id_sanpham = $id_sanpham";
    mysqli_query($mysqli, $update_kho);

    // Lưu chi tiết đơn hàng
    $sql_chitiet = "INSERT INTO chitietdonhang(ma_giohang, id_sanpham, soluong)
                    VALUES ('$ma_giohang', '$id_sanpham', '$soluong')";
    mysqli_query($mysqli, $sql_chitiet);
}

// 3. Xóa giỏ hàng và chuyển trang
unset($_SESSION['cart']);
echo "<p style='color:green;'>🎉 Đặt hàng thành công! Mã đơn hàng của bạn là: <strong>$ma_giohang</strong></p>";
echo "<meta http-equiv='refresh' content='2;url=../../index.php?quanly=camon'>";
?>
