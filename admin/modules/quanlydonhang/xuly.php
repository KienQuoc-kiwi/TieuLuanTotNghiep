<?php
include('../../../config/config.php');

// Sửa đơn hàng
if (isset($_POST['suadonhang'])) {
    $ma_giohang = $_POST['ma_giohang'];
    $ngaytao = $_POST['ngaytao'];
    $ghichu = $_POST['ghichu'];

    $sql_update = "UPDATE donhang SET ngaytao = '$ngaytao', ghichu = '$ghichu' WHERE ma_giohang = '$ma_giohang'";
    mysqli_query($mysqli, $sql_update);
    header('Location: ../../indexad.php?action=donhang&query=lietke');
}

// Xóa đơn hàng
if (isset($_GET['xoa']) && isset($_GET['code'])) {
    $code = $_GET['code'];

    // Xóa chi tiết đơn hàng trước
    $sql_chitiet = "DELETE FROM chitietdonhang WHERE ma_giohang = '$code'";
    mysqli_query($mysqli, $sql_chitiet);

    // Sau đó xóa đơn hàng
    $sql_donhang = "DELETE FROM donhang WHERE ma_giohang = '$code'";
    mysqli_query($mysqli, $sql_donhang);

    header('Location: ../../indexad.php?action=quanlydonhang&query=lietke');
}

if (isset($_POST['xacnhan'])) {
    $update_sql = "UPDATE donhang SET trangthai = 'Đã xác nhận' WHERE ma_giohang = '$code'";
    $query_update = mysqli_query($mysqli, $update_sql);
    if ($query_update) {
        echo "<p style='color:green;'>✔️ Đơn hàng đã được xác nhận thành công.</p>";
        // (Tùy chọn) Gửi email hoặc thông báo tại đây.
    } else {
        echo "<p style='color:red;'>❌ Lỗi khi xác nhận đơn hàng: " . mysqli_error($mysqli) . "</p>";
    }
}
?>