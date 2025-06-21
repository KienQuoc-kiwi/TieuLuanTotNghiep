<?php
ob_start();
include('../../../config/config.php');

if (isset($_POST['suatonkho'])) {
    $id_sanpham = (int)$_POST['id_sanpham'];
    $soluong = (int)$_POST['soluong'];
    $lydo = trim($_POST['lydo']);
    $id_admin = 1; // Thay bằng $_SESSION['id_admin'] nếu có

    if ($id_sanpham <= 0 || $soluong < 0 || empty($lydo)) {
        echo "Dữ liệu không hợp lệ.";
        exit;
    }

    // Lấy số lượng tồn kho cũ
    $sql_old = "SELECT soluong FROM sanpham WHERE id_sanpham = ?";
    $stmt_old = mysqli_prepare($mysqli, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "i", $id_sanpham);
    mysqli_stmt_execute($stmt_old);
    $result_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($result_old);
    $soluong_cu = (int)$row_old['soluong'];
    mysqli_stmt_close($stmt_old);

    // Tính thay đổi
    $soluong_thaydoi = $soluong - $soluong_cu;
    $loai_thaydoi = ($soluong_thaydoi > 0) ? 'nhapkho' : ($soluong_thaydoi < 0) ? 'xuatkho' : 'dieuchinh';

    // Cập nhật tồn kho
    $sql_update = "UPDATE sanpham SET soluong = ? WHERE id_sanpham = ?";
    $stmt = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt, "ii", $soluong, $id_sanpham);
    if (mysqli_stmt_execute($stmt)) {
        // Ghi lịch sử
        $sql_log = "INSERT INTO lichsukho (id_bienthe, id_sanpham, soluong_thaydoi, loai_thaydoi, id_admin, lydo)
                    VALUES (NULL, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($mysqli, $sql_log);
        mysqli_stmt_bind_param($stmt_log, "iisis", $id_sanpham, $soluong_thaydoi, $loai_thaydoi, $id_admin, $lydo);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        header('Location: ../../indexad.php?action=quanlytonkho');
    } else {
        echo "Lỗi cập nhật tồn kho.";
    }
    mysqli_stmt_close($stmt);
}

ob_end_clean();
?>