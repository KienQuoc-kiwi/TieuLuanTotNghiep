<?php
session_start();
include("../../config/config.php");

// Tăng số lượng
if (isset($_GET['cong'])) {
    $id = $_GET['cong'];
    $product = [];
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] == $id) {
            // Tăng số lượng nếu nhỏ hơn hoặc bằng 9
            $tangsoluong = $cart_item['soluong'] < 10 ? $cart_item['soluong'] + 1 : $cart_item['soluong'];
            $product[] = [
                'tensanpham' => $cart_item['tensanpham'],
                'id' => $cart_item['id'],
                'soluong' => $tangsoluong,
                'giasp' => $cart_item['giasp'],
                'hinhanh' => $cart_item['hinhanh'],
                'masp' => $cart_item['masp']
            ];
        } else {
            // Giữ nguyên các sản phẩm khác
            $product[] = [
                'tensanpham' => $cart_item['tensanpham'],
                'id' => $cart_item['id'],
                'soluong' => $cart_item['soluong'],
                'giasp' => $cart_item['giasp'],
                'hinhanh' => $cart_item['hinhanh'],
                'masp' => $cart_item['masp']
            ];
        }
    }
    $_SESSION['cart'] = $product; // Gán lại giỏ hàng sau khi xử lý toàn bộ
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Giảm số lượng
if (isset($_GET['tru'])) {
    $id = $_GET['tru'];
    $product = [];
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] == $id) {
            // Giảm số lượng nếu lớn hơn 1
            $giamsoluong = $cart_item['soluong'] > 1 ? $cart_item['soluong'] - 1 : $cart_item['soluong'];
            $product[] = [
                'tensanpham' => $cart_item['tensanpham'],
                'id' => $cart_item['id'],
                'soluong' => $giamsoluong,
                'giasp' => $cart_item['giasp'],
                'hinhanh' => $cart_item['hinhanh'],
                'masp' => $cart_item['masp']
            ];
        } else {
            // Giữ nguyên các sản phẩm khác
            $product[] = [
                'tensanpham' => $cart_item['tensanpham'],
                'id' => $cart_item['id'],
                'soluong' => $cart_item['soluong'],
                'giasp' => $cart_item['giasp'],
                'hinhanh' => $cart_item['hinhanh'],
                'masp' => $cart_item['masp']
            ];
        }
    }
    $_SESSION['cart'] = $product; // Gán lại giỏ hàng sau khi xử lý toàn bộ
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Xóa sản phẩm
if (isset($_SESSION['cart']) && isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $product = [];
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] != $id) {
            $product[] = [
                'tensanpham' => $cart_item['tensanpham'],
                'id' => $cart_item['id'],
                'soluong' => $cart_item['soluong'],
                'giasp' => $cart_item['giasp'],
                'hinhanh' => $cart_item['hinhanh'],
                'masp' => $cart_item['masp']
            ];
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Xóa tất cả
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['themgiohang'])) {
    $id = $_GET['id_sanpham'];
    $soluong = 1;
    $sql = "SELECT * FROM sanpham WHERE id_sanpham='" . $id . "' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        $new_product = [[
            'tensanpham' => $row['tensanpham'],
            'id' => $id,
            'soluong' => $soluong,
            'giasp' => $row['giasp'],
            'hinhanh' => $row['hinhanh'],
            'masp' => $row['masp']
        ]];
        // Kiểm tra session giỏ hàng tồn tại
        if (isset($_SESSION['cart'])) {
            $found = false;
            $product = [];
            foreach ($_SESSION['cart'] as $cart_item) {
                if ($cart_item['id'] == $id) {
                    $product[] = [
                        'tensanpham' => $cart_item['tensanpham'],
                        'id' => $cart_item['id'],
                        'soluong' => $cart_item['soluong'] + 1,
                        'giasp' => $cart_item['giasp'],
                        'hinhanh' => $cart_item['hinhanh'],
                        'masp' => $cart_item['masp']
                    ];
                    $found = true;
                } else {
                    $product[] = [
                        'tensanpham' => $cart_item['tensanpham'],
                        'id' => $cart_item['id'],
                        'soluong' => $cart_item['soluong'],
                        'giasp' => $cart_item['giasp'],
                        'hinhanh' => $cart_item['hinhanh'],
                        'masp' => $cart_item['masp']
                    ];
                }
            }
            if (!$found) {
                $_SESSION['cart'] = array_merge($product, $new_product);
            } else {
                $_SESSION['cart'] = $product;
            }
        } else {
            $_SESSION['cart'] = $new_product;
        }
    }
    header('Location:../../index.php?quanly=giohang');
    exit();
}
?>