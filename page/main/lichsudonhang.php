<?php
include("config/config.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['id_khach']) || !isset($_SESSION['dangkyk'])) {
    echo "Bạn cần đăng nhập để xem lịch sử đơn hàng.";
    exit;
}

$id_khach = $_SESSION['id_khach'];
$ten_dangnhap = $_SESSION['dangkyk'];
$user_greeting = 'Xin chào: <span class="highlight">' . htmlspecialchars($ten_dangnhap) . '</span>';
$user_id = htmlspecialchars($id_khach);

// Kiểm tra kết nối $mysqli
if (!$mysqli || $mysqli->connect_error) {
    echo "Lỗi kết nối cơ sở dữ liệu: " . ($mysqli ? $mysqli->connect_error : " учет thể kết nối.");
    exit();
}

// Lấy danh sách đơn hàng của khách hàng
$sql_donhang = "SELECT * FROM donhang WHERE id_khach = ? ORDER BY ngaytao DESC";
$stmt_donhang = $mysqli->prepare($sql_donhang);
if (!$stmt_donhang) {
    echo "Lỗi chuẩn bị truy vấn: " . $mysqli->error;
    exit();
}
$stmt_donhang->bind_param("i", $id_khach);
$stmt_donhang->execute();
$result_donhang = $stmt_donhang->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/giohang.css">
</head>

<body>

    <div class="lichsudonhang">
        <div class="cart-items">
            <p class="title">Lịch sử đơn hàng</p>
            <p class="user-info"><?php echo $user_greeting; ?> (ID: <?php echo $user_id; ?>)</p>

            <?php if ($result_donhang->num_rows > 0) { ?>
                <?php while ($donhang = $result_donhang->fetch_assoc()) {
                    $ma_giohang = $donhang['ma_giohang'];
                    // Lấy chi tiết đơn hàng
                    $sql_chitiet = "SELECT ct.*, sp.tensanpham, sp.masp, sp.giasp, bt.hinhanh 
                                FROM chitietdonhang ct
                                JOIN sanpham sp ON ct.id_sanpham = sp.id_sanpham
                                LEFT JOIN bienthesanpham bt ON ct.id_bienthe = bt.id_bienthe
                                WHERE ct.ma_giohang = ?";
                    $stmt_chitiet = $mysqli->prepare($sql_chitiet);
                    if (!$stmt_chitiet) {
                        echo "Lỗi chuẩn bị truy vấn chi tiết: " . $mysqli->error;
                        exit();
                    }
                    $stmt_chitiet->bind_param("s", $ma_giohang);
                    $stmt_chitiet->execute();
                    $result_chitiet = $stmt_chitiet->get_result();

                    // Tính tổng tiền cho đơn hàng
                    $tongtien = 0;
                    $result_chitiet->data_seek(0);
                    while ($item = $result_chitiet->fetch_assoc()) {
                        $thanhtien = $item['soluong'] * $item['giasp'];
                        $tongtien += $thanhtien;
                    }
                ?>
                    <div class="donhang-item">
                        <h3>Mã đơn hàng: <?php echo htmlspecialchars($donhang['ma_giohang']); ?></h3>
                        <p>Ngày đặt: <?php echo date('d/m/Y H:i:s', strtotime($donhang['ngaytao'])); ?></p>
                        <p>
                            Trạng thái:
                            <?php if ($donhang['trangthai'] == 1): ?>
                                <span style="color: green;">✔️ Đã được duyệt</span>
                            <?php else: ?>
                                <span style="color: orange;">⏳ Chờ duyệt</span>
                            <?php endif; ?>
                        </p>

                        <table border="1" width="100%" style="text-align:center;">
                            <tr>
                                <th>ID</th>
                                <th>MÃ SẢN PHẨM</th>
                                <th>TÊN SẢN PHẨM</th>
                                <th>HÌNH ẢNH</th>
                                <th>SỐ LƯỢNG</th>
                                <th>GIÁ SẢN PHẨM</th>
                                <th>THÀNH TIỀN</th>
                            </tr>
                            <?php
                            $i = 0;
                            $result_chitiet->data_seek(0);
                            while ($item = $result_chitiet->fetch_assoc()) {
                                $i++;
                                $thanhtien = $item['soluong'] * $item['giasp'];
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($item['masp']); ?></td>
                                    <td><?php echo htmlspecialchars($item['tensanpham']); ?></td>
                                    <td><img src="admin/modules/quanlybienthe/bientheuploads/<?php echo htmlspecialchars($item['hinhanh']); ?>" style="width: 50px;"></td>
                                    <td><?php echo $item['soluong']; ?></td>
                                    <td><?php echo number_format($item['giasp'], 0, ',', '.') . ' vnđ'; ?></td>
                                    <td><?php echo number_format($thanhtien, 0, ',', '.') . ' vnđ'; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7">
                                    <p><strong>Tổng tiền:</strong> <?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                <?php
                    $stmt_chitiet->close();
                } ?>
            <?php } else { ?>
                <table border="1" width="100%" style="text-align:center;">
                    <tr>
                        <td colspan="7">
                            <p>Bạn chưa có đơn hàng nào.</p>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <?php $stmt_donhang->close(); ?>
        </div>
    </div>

    <h2>Gợi ý cho bạn</h2>
    <div class="suggestion-section">
        <div class="suggestion-grid">
            <div class="suggestion-item">
                <img src="path/to/white-tshirt.jpg" alt="White T-shirt">
                <p>Áo thun trắng</p>
            </div>
            <div class="suggestion-item">
                <img src="path/to/navy-tshirt.jpg" alt="Navy T-shirt">
                <p>Áo thun xanh navy</p>
            </div>
            <div class="suggestion-item">
                <img src="path/to/black-sandal.jpg" alt="Black Sandal">
                <p>Dép đen</p>
            </div>
            <div class="suggestion-item">
                <img src="path/to/blue-sandal.jpg" alt="Blue Sandal">
                <p>Dép xanh</p>
            </div>
        </div>
    </div>

</body>

</html>