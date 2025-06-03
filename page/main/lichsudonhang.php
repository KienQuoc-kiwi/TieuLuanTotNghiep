<?php
// session_start();
include("config/config.php");

if (!isset($_SESSION['id_khach'])) {
    echo "Bạn cần đăng nhập để xem giỏ hàng.";
    exit;
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<div class="lichsudonhang">
    <h2>Lịch sử đơn hàng</h2>
    <table border="1" width="100%" style="text-align:center;">
        <tr>
            <th>ID</th>
            <th>MÃ SẢN PHẨM</th>
            <th>TÊN SẢN PHẨM</th>
            <th>HÌNH ẢNH</th>
            <th>SỐ LƯỢNG</th>
            <th>GIÁ SẢN PHẨM</th>
            <th>THÀNH TIỀN</th>
            <th>QUẢN LÝ</th>
        </tr>
        <?php
        $tongtien = 0;
        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                $thanhtien = $item['soluong'] * $item['giasp'];
                $tongtien += $thanhtien;
                ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['masp']; ?></td>
                    <td><?php echo $item['tensanpham']; ?></td>
                    <td><img src="admin/modules/quanlysp/uploads/<?php echo $item['hinhanh']; ?>" style="width: 50px;"></td>
                    <td><?php echo $item['soluong']; ?></td>
                    <td><?php echo number_format($item['giasp'], 0, ',', '.') . ' vnđ'; ?></td>
                    <td><?php echo number_format($thanhtien, 0, ',', '.') . ' vnđ'; ?></td>
                    <td><a href="page/main/themgiohang.php?xoa=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a></td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="8">Giỏ hàng trống</td></tr>';
        }
        ?>
    </table>

    <p><strong>Tổng tiền:</strong> <?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></p>
    <br>
    <a href="pages/main/themgiohang.php?xoatatca=1" onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')">
        Xóa tất cả
    </a>
</div>

<!-- Tổng đơn hàng -->
<!-- <?php if (!empty($cart_items)) { ?>
<div class="tong-don-hang">
    <p>Số lượng sản phẩm: <?php echo count($cart_items); ?> sản phẩm</p>
    <p>Tổng tiền: <?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></p>
    <p>Tổng cộng: <?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></p>
    <button class="thanhtoan-btn" onclick="window.location.href='index.php?quanly=thanhtoan'">ĐẶT XUẤT THANH TOÁN</button>
</div>
<?php } ?> -->

<!-- Gợi ý cho bạn section -->
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
