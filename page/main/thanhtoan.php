<p>Thanh toán</p>
<?php
session_start();
include("../../config/config.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['id_khach']) || !isset($_SESSION['cart'])) {
    echo "Lỗi: chưa đăng nhập hoặc giỏ hàng trống.";
    exit;
}

$idkhachhang = $_SESSION['id_khach'];
$code_order = rand(0, 9999);

// Thêm đơn hàng
$insert_cart = "INSERT INTO donhang (id_khach, ma_giohang, trangthai, ngaytao)
                VALUES ('$idkhachhang', '$code_order', 1, NOW())";

$cart_query = mysqli_query($mysqli, $insert_cart);

if ($cart_query) {
    $loi_tonkho = false;

    foreach ($_SESSION['cart'] as $value) {
        $id_sanpham = $value['id'];
        $soluong = $value['soluong'];

        // Kiểm tra tồn kho
        $check = mysqli_query($mysqli, "SELECT soluong FROM sanpham WHERE id_sanpham = $id_sanpham");
        $row = mysqli_fetch_assoc($check);

        if ($row['soluong'] >= $soluong) {
            // Cập nhật tồn kho
            $update_sql = "UPDATE sanpham SET soluong = soluong - $soluong WHERE id_sanpham = $id_sanpham";
            mysqli_query($mysqli, $update_sql);

            // Thêm chi tiết đơn hàng
            $insert_order_details = "INSERT INTO chitietdonhang (id_sanpham, ma_giohang, soluong) VALUES ('$id_sanpham', '$code_order', '$soluong')";
            mysqli_query($mysqli, $insert_order_details);
        } else {
            echo "Sản phẩm ID $id_sanpham không đủ số lượng tồn kho!<br>";
            $loi_tonkho = true;
        }
    }

    // Nếu không có lỗi, xóa giỏ hàng
    if (!$loi_tonkho) {
        unset($_SESSION['cart']);
        header("Location:../../index.php?quanly=camon");
        exit;
    } else {
        echo "<p><a href='../../index.php'>Quay lại giỏ hàng</a></p>";
    }
} else {
    echo "Lỗi khi đặt hàng.";
}
?>