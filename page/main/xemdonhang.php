<?php
// session_start();
include("config/config.php");

if (!isset($_SESSION['id_khach'])) {
    echo "Bạn cần đăng nhập để xem đơn hàng.";
    exit;
}

if (!isset($_GET['code'])) {
    echo "Không tìm thấy mã đơn hàng.";
    exit;
}

$ma_giohang = $_GET['code'];

// Lấy thông tin đơn hàng
$sql_order = "SELECT * FROM donhang WHERE ma_giohang = '$ma_giohang' AND id_khach = '{$_SESSION['id_khach']}' LIMIT 1";
$query_order = mysqli_query($mysqli, $sql_order);
$order = mysqli_fetch_assoc($query_order);

if (!$order) {
    echo "Đơn hàng không tồn tại hoặc không thuộc về bạn.";
    exit;
}

// Lấy chi tiết đơn hàng
$sql_details = "SELECT chitietdonhang.*, sanpham.tensanpham, sanpham.giasp , sanpham.hinhanh
                FROM chitietdonhang 
                JOIN sanpham ON chitietdonhang.id_sanpham = sanpham.id_sanpham 
                WHERE chitietdonhang.ma_giohang = '$ma_giohang'";

$query_details = mysqli_query($mysqli, $sql_details);

?>

<h2>Chi tiết đơn hàng: <?php echo $ma_giohang; ?></h2>
<p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order['ngaytao'])); ?></p>
<p><strong>Trạng thái:</strong> <?php echo $order['trangthai']; ?></p>

<table border="1" width="100%" style="text-align:center;">
    <tr>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Hình ảnh</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
    </tr>
    <?php
    $tongtien = 0;
    while ($row = mysqli_fetch_assoc($query_details)) {
        $thanhtien = $row['giasp'] * $row['soluong'];
        $tongtien += $thanhtien;
        ?>
        <tr>
            <td><?php echo $row['tensanpham']; ?></td>
            <td><?php echo number_format($row['giasp'], 0, ',', '.') . 'đ'; ?></td>
            <td><img src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" alt="hình lỗi"></td>
            <td><?php echo $row['soluong']; ?></td>
            <td><?php echo number_format($thanhtien, 0, ',', '.') . 'đ'; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="text-align:right;"><strong>Tổng tiền:</strong></td>
        <td><strong><?php echo number_format($tongtien, 0, ',', '.') . 'đ'; ?></strong></td>
    </tr>
</table>

<p><a href="index.php?quanly=lichsudonhang">← Quay lại lịch sử đơn hàng</a></p>
