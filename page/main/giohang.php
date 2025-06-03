<?php
// session_start();
include("config/config.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['dangkyk'])) {
  $user_greeting = 'Xin chào: <span class="highlight">' . htmlspecialchars($_SESSION['dangkyk']) . '</span>';
  $user_id = htmlspecialchars($_SESSION['id_khach']);
} else {
  $user_greeting = '';
  $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/giohang.css">
</head>

<body>

  <div class="giohang">
    <div class="cart-items">
      <p class="title">Giỏ hàng</p>
      <?php if (!empty($user_greeting)) { ?>
        <p class="user-info"><?php echo $user_greeting; ?> (ID: <?php echo $user_id; ?>)</p>
      <?php } ?>

      <table>
        <!-- <tr>
          <th>ID</th>
          <th>Mã sản phẩm</th>
          <th>Tên sản phẩm</th>
          <th>Hình ảnh</th>
          <th>Số lượng</th>
          <th>Giá sản phẩm</th>
          <th>Thành tiền</th>
          <th>Quản lý</th>
        </tr> -->
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
          $i = 0;
          $tongtien = 0;
          foreach ($_SESSION['cart'] as $cart_item) {
            $thanhtien = $cart_item['soluong'] * $cart_item['giasp'];
            $tongtien += $thanhtien;
            $i++;
        ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo htmlspecialchars($cart_item['masp']); ?></td>
              <td><?php echo htmlspecialchars($cart_item['tensanpham']); ?></td>
              <td><img src="admin/modules/quanlysp/uploads/<?php echo htmlspecialchars($cart_item['hinhanh']); ?>" alt="Hình ảnh sản phẩm"></td>
              <td class="quantity-control">
                <a href="page/main/themgiohang.php?tru=<?php echo $cart_item['id']; ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
                <?php echo $cart_item['soluong']; ?>
                <a href="page/main/themgiohang.php?cong=<?php echo $cart_item['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
              </td>
              <td><?php echo number_format($cart_item['giasp'], 0, ',', '.') . 'vnđ'; ?></td>
              <td><?php echo number_format($thanhtien, 0, ',', '.') . 'vnđ'; ?></td>
              <td><a href="page/main/themgiohang.php?xoa=<?php echo $cart_item['id']; ?>">Xóa</a></td>
            </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="8">
              <div>
                <p>Tổng tiền: <?php echo number_format($tongtien, 0, ',', '.') . 'vnđ'; ?></p>
                <p><a href="page/main/themgiohang.php?xoatatca=1">Xóa tất cả sản phẩm</a></p>
              </div>

            </td>
          </tr>
        <?php
        } else {
        ?>
          <tr>
            <td colspan="8">
              <p>Hiện tại giỏ hàng đang trống</p>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
    </div>

    <div class="cart-summary">
      <h3>Tổng đơn hàng</h3>
      <div class="summary-item">
        <span>Số lượng sản phẩm</span>
        <span><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?> sản phẩm</span>
      </div>
      <div class="summary-item">
        <span>Tổng tiền</span>
        <span><?php echo isset($_SESSION['cart']) ? number_format($tongtien, 0, ',', '.') . 'vnđ' : '0vnđ'; ?></span>
      </div>
      <div class="summary-item total">
        <span>Tổng cộng</span>
        <span><?php echo isset($_SESSION['cart']) ? number_format($tongtien, 0, ',', '.') . 'vnđ' : '0vnđ'; ?></span>
      </div>
      <?php if (isset($_SESSION['dangkyk'])) { ?>
        <p><a href="page/main/thanhtoan.php" class="dathang">thanh toán</a></p>
      <?php } else { ?>
        <p><a href="page/main/dangkykhach.php" class="dangkydathang">Đăng ký để thanh toán</a></p>
      <?php } ?>
    </div>
  </div>

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
</body>

</html>