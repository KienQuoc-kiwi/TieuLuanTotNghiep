<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include("../../config/config.php");

if (!isset($_SESSION['id_khach']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p style='color:red;'>❌ Bạn chưa đăng nhập hoặc giỏ hàng đang trống.</p>";
    echo "<p><a href='../../index.php?quanly=giohang'>⬅️ Quay lại giỏ hàng</a></p>";
    exit;
}

$id_khach = $_SESSION['id_khach'];
$ma_giohang = 'DH' . time();
$ngaytao = date('Y-m-d H:i:s');
$trangthai = 0;

$loi = false;

foreach ($_SESSION['cart'] as $item) {
    if (
        empty($item['id_sanpham']) || 
        empty($item['id_bienthe']) || 
        empty($item['soluong'])
    ) {
        $loi = true;
        echo "<p style='color:red;'>❌ Thiếu thông tin sản phẩm trong giỏ hàng.</p>";
        break;
    }

    $id_sanpham = intval($item['id_sanpham']);
    $id_bienthe = intval($item['id_bienthe']);
    $soluong = intval($item['soluong']);

    // Kiểm tra tồn kho sản phẩm
    $sql_sp = "SELECT soluong FROM sanpham WHERE id_sanpham = ?";
    $stmt_sp = $mysqli->prepare($sql_sp);
    $stmt_sp->bind_param("i", $id_sanpham);
    $stmt_sp->execute();
    $result_sp = $stmt_sp->get_result();
    $data_sp = $result_sp->fetch_assoc();
    $stmt_sp->close();

    // Kiểm tra tồn kho biến thể
    $sql_bt = "SELECT soluongtonkho FROM bienthesanpham WHERE id_bienthe = ?";
    $stmt_bt = $mysqli->prepare($sql_bt);
    $stmt_bt->bind_param("i", $id_bienthe);
    $stmt_bt->execute();
    $result_bt = $stmt_bt->get_result();
    $data_bt = $result_bt->fetch_assoc();
    $stmt_bt->close();

    if (!$data_sp || $data_sp['soluong'] < $soluong) {
        echo "<p style='color:red;'>❌ Sản phẩm ID $id_sanpham không đủ hàng trong kho.</p>";
        $loi = true;
    }

    if (!$data_bt || $data_bt['soluongtonkho'] < $soluong) {
        echo "<p style='color:red;'>❌ Biến thể sản phẩm ID $id_bienthe không đủ hàng trong kho.</p>";
        $loi = true;
    }
}

if ($loi) {
    echo "<p><a href='../../index.php?quanly=giohang'>⬅️ Quay lại giỏ hàng</a></p>";
    exit;
}

// Tạo đơn hàng
$stmt_dh = $mysqli->prepare("INSERT INTO donhang(ma_giohang, id_khach, ngaytao, trangthai) VALUES (?, ?, ?, ?)");
$stmt_dh->bind_param("sisi", $ma_giohang, $id_khach, $ngaytao, $trangthai);
$stmt_dh->execute();
$stmt_dh->close();

// Lưu chi tiết đơn hàng và trừ kho
foreach ($_SESSION['cart'] as $item) {
    $id_sanpham = intval($item['id_sanpham']);
    $id_bienthe = intval($item['id_bienthe']);
    $soluong = intval($item['soluong']);

    // Trừ kho chính
    $stmt_up_sp = $mysqli->prepare("UPDATE sanpham SET soluong = soluong - ? WHERE id_sanpham = ?");
    $stmt_up_sp->bind_param("ii", $soluong, $id_sanpham);
    $stmt_up_sp->execute();
    $stmt_up_sp->close();

    // Trừ kho biến thể
    $stmt_up_bt = $mysqli->prepare("UPDATE bienthesanpham SET soluongtonkho = soluongtonkho - ? WHERE id_bienthe = ?");
    $stmt_up_bt->bind_param("ii", $soluong, $id_bienthe);
    $stmt_up_bt->execute();
    $stmt_up_bt->close();

    // Lưu chi tiết đơn hàng
    $stmt_ct = $mysqli->prepare("INSERT INTO chitietdonhang(ma_giohang, id_sanpham, id_bienthe, soluong) VALUES (?, ?, ?, ?)");
    $stmt_ct->bind_param("siii", $ma_giohang, $id_sanpham, $id_bienthe, $soluong);
    $stmt_ct->execute();
    $stmt_ct->close();
}

unset($_SESSION['cart']);
echo "<p style='color:green;'>🎉 Đặt hàng thành công! Mã đơn hàng: <strong>$ma_giohang</strong></p>";
echo "<meta http-equiv='refresh' content='2;url=../../index.php?quanly=camon'>";
?>
