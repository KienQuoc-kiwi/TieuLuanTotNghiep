<?php
session_start();
include("../../config/config.php");
date_default_timezone_set("Asia/Ho_Chi_Minh");

if (isset($_POST['thembinhluan'])) {
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['id_user']) || !isset($_SESSION['id_vaitro'])) {
        // Lưu URL hiện tại để chuyển hướng sau khi đăng nhập
        $_SESSION['redirect_url'] = $_SERVER['HTTP_REFERER'];
        echo '<script>alert("Bạn cần đăng nhập để bình luận!"); window.location.href = "dangnhapkhach.php";</script>';
        exit();
    }

    // Chỉ cho phép khách hàng (id_vaitro = 3) bình luận
    if ($_SESSION['id_vaitro'] != 3) {
        echo '<script>alert("Chỉ khách hàng mới có thể bình luận!"); window.location.href = "../../index.php?quanly=sanpham&id=' . htmlspecialchars($_POST['id_sanpham_test']) . '";</script>';
        exit();
    }

    $idkhachhang = $_SESSION['id_user'];
    $id_sp = $_POST['id_sanpham_test'] ?? null;
    $binhluan = trim($_POST['content'] ?? '');
    $ngay = date("H:i:s d-m-Y", time());

    // Kiểm tra dữ liệu đầu vào
    if (empty($binhluan)) {
        echo '<script>alert("Vui lòng nhập nội dung bình luận!"); window.location.href = "../../index.php?quanly=sanpham&id=' . htmlspecialchars($id_sp) . '";</script>';
        exit();
    }

    if (empty($id_sp) || !is_numeric($id_sp)) {
        echo '<script>alert("Sản phẩm không hợp lệ!"); window.location.href = "../../index.php";</script>';
        exit();
    }

    // Kiểm tra xem id_user có tồn tại trong bảng khachhang không
    $sql_check_khach = "SELECT id_khach FROM khachhang WHERE id_khach = ?";
    $stmt_check = $mysqli->prepare($sql_check_khach);
    $stmt_check->bind_param("i", $idkhachhang);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        // id_khach không tồn tại, yêu cầu đăng nhập lại
        unset($_SESSION['id_user']);
        unset($_SESSION['id_vaitro']);
        unset($_SESSION['type_user']);
        echo '<script>alert("Phiên đăng nhập không hợp lệ! Vui lòng đăng nhập lại."); window.location.href = "../../index.php?quanly=dangnhap";</script>';
        $stmt_check->close();
        exit();
    }
    $stmt_check->close();

    // Kiểm tra xem id_sanpham có tồn tại trong bảng sanpham không
    $sql_check_sp = "SELECT id_sanpham FROM sanpham WHERE id_sanpham = ?";
    $stmt_check_sp = $mysqli->prepare($sql_check_sp);
    $stmt_check_sp->bind_param("i", $id_sp);
    $stmt_check_sp->execute();
    $result_check_sp = $stmt_check_sp->get_result();

    if ($result_check_sp->num_rows === 0) {
        echo '<script>alert("Sản phẩm không tồn tại!"); window.location.href = "../../index.php";</script>';
        $stmt_check_sp->close();
        exit();
    }
    $stmt_check_sp->close();

    // Sử dụng prepared statement để chèn bình luận
    $sql_them = "INSERT INTO binhluan (id_khach, id_sanpham, noidung, ngaybinhluan) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql_them);
    if ($stmt === false) {
        echo '<script>alert("Lỗi chuẩn bị câu lệnh SQL: ' . htmlspecialchars($mysqli->error) . '");</script>';
        exit();
    }

    $stmt->bind_param("iiss", $idkhachhang, $id_sp, $binhluan, $ngay);
    if ($stmt->execute()) {
        // Thêm bình luận thành công
        echo '<script>window.location.href = "../../index.php?quanly=sanpham&id=' . htmlspecialchars($id_sp) . '";</script>';
    } else {
        // Lỗi khi thêm bình luận
        echo '<script>alert("Lỗi khi thêm bình luận: ' . htmlspecialchars($stmt->error) . '"); window.location.href = "../../index.php?quanly=sanpham&id=' . htmlspecialchars($id_sp) . '";</script>';
    }
    $stmt->close();
}
?>