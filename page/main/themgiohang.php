<?php
session_start();
include("../../config/config.php");

// Tăng số lượng
if (isset($_GET['cong'])) {
    $key = $_GET['cong'];
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['soluong'] += 1;
    }
    header('location:../../index.php?quanly=giohang');
    exit();
}

// Giảm số lượng
if (isset($_GET['tru'])) {
    $key = $_GET['tru'];
    if (isset($_SESSION['cart'][$key]) && $_SESSION['cart'][$key]['soluong'] > 1) {
        $_SESSION['cart'][$key]['soluong'] -= 1;
    }
    header('location:../../index.php?quanly=giohang');
    exit();
}

// Xóa từng sản phẩm
if (isset($_GET['xoa'])) {
    unset($_SESSION['cart'][$_GET['xoa']]);
    header('location:../../index.php?quanly=giohang');
    exit();
}

// Xóa tất cả
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('location:../../index.php?quanly=giohang');
    exit();
}

// Thêm sản phẩm
if (isset($_POST['themgiohang'])) {
    // Kiểm tra dữ liệu đầu vào
    if (
        !isset($_POST['id_sanpham']) || !is_numeric($_POST['id_sanpham']) ||
        !isset($_POST['soluong']) || !is_numeric($_POST['soluong']) || $_POST['soluong'] <= 0 ||
        !isset($_POST['kichco']) || empty($_POST['kichco']) ||
        !isset($_POST['mausac']) || empty($_POST['mausac'])
    ) {
        echo "<p style='color:red;'>❌ Vui lòng nhập đầy đủ thông tin sản phẩm (kích cỡ, màu sắc, số lượng).</p>";
        echo "<p><a href='../../index.php?quanly=giohang'>⬅️ Quay lại giỏ hàng</a></p>";
        exit();
    }

    $id_sanpham = intval($_POST['id_sanpham']);
    $tensanpham = $_POST['tensanpham'];
    $giasp = intval($_POST['giasp']);
    $hinhanh = $_POST['hinhanh'];
    $soluong = intval($_POST['soluong']);
    $kichco = $_POST['kichco'];
    $mausac = $_POST['mausac'];

    // Lấy id_bienthe
    $stmt = $mysqli->prepare("SELECT id_bienthe, soluongtonkho FROM bienthesanpham WHERE id_sanpham = ? AND kichco LIKE ? AND mausac = ? LIMIT 1");
    $kichco_pattern = "%$kichco%"; // Sử dụng LIKE để tìm kích cỡ trong chuỗi
    $stmt->bind_param("iss", $id_sanpham, $kichco_pattern, $mausac);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $id_bienthe = $row['id_bienthe'];
        $soluongtonkho = $row['soluongtonkho'];

        // Kiểm tra tồn kho
        if ($soluong > $soluongtonkho) {
            echo "<p style='color:red;'>❌ Số lượng yêu cầu ($soluong) vượt quá tồn kho ($soluongtonkho) cho sản phẩm này.</p>";
            echo "<p><a href='../../index.php?quanly=sanpham&id=$id_sanpham'>⬅️ Quay lại sản phẩm</a></p>";
            $stmt->close();
            exit();
        }
    } else {
        echo "<p style='color:red;'>❌ Không tìm thấy biến thể sản phẩm với kích cỡ và màu sắc đã chọn.</p>";
        echo "<p><a href='../../index.php?quanly=sanpham&id=$id_sanpham'>⬅️ Quay lại sản phẩm</a></p>";
        $stmt->close();
        exit();
    }
    $stmt->close();

    $key = $id_sanpham . '-' . $kichco . '-' . $mausac;

    $item = [
        'id' => $key,
        'id_sanpham' => $id_sanpham,
        'id_bienthe' => $id_bienthe,
        'tensanpham' => $tensanpham,
        'giasp' => $giasp,
        'hinhanh' => $hinhanh,
        'soluong' => $soluong,
        'kichco' => $kichco,
        'mausac' => $mausac
    ];

    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['soluong'] += $soluong;
    } else {
        $_SESSION['cart'][$key] = $item;
    }

    header('location:../../index.php?quanly=giohang');
    exit();
}
?>