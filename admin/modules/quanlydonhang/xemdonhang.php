<?php
$code = $_GET['code']; // mã đơn hàng

// Lấy thông tin đơn hàng và khách hàng
$sql_donhang = "
    SELECT donhang.ma_giohang, donhang.ngaytao, donhang.trangthai, 
           khachhang.ten_khach
    FROM donhang 
    JOIN khachhang ON donhang.id_khach = khachhang.id_khach
    WHERE donhang.ma_giohang = '$code' LIMIT 1
";
$query_donhang = mysqli_query($mysqli, $sql_donhang);
if (!$query_donhang) {
  echo "Lỗi SQL: " . mysqli_error($mysqli);
  exit;
}
$row_donhang = mysqli_fetch_array($query_donhang);

// Lấy chi tiết sản phẩm
$sql_chitiet = "
    SELECT sanpham.tensanpham, sanpham.giasp, sanpham.hinhanh, 
           chitietdonhang.soluong
    FROM chitietdonhang 
    JOIN sanpham ON chitietdonhang.id_sanpham = sanpham.id_sanpham 
    WHERE chitietdonhang.ma_giohang = '$code'
";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);

// Khởi tạo mảng sản phẩm (tránh lỗi)
$sanpham_rows = [];
$tongtien = 0;
while ($row = mysqli_fetch_array($query_chitiet)) {
  $thanhtien = $row['giasp'] * $row['soluong'];
  $tongtien += $thanhtien;
  $row['thanhtien'] = $thanhtien;
  $sanpham_rows[] = $row;
}
?>

<div class="qldh-xem-wrapper">
  <div class="qldh-thongtin">
    <h2>Chi tiết đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> <?= $row_donhang['ma_giohang']; ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?= date("d/m/Y", strtotime($row_donhang['ngaytao'])); ?></p>
    <p><strong>Trạng thái:</strong>
      <?php if ($row_donhang['trangthai'] == 1): ?>
        <span class="qldh-trangthai-daduyet">✔️ Đã được duyệt</span>
      <?php else: ?>
        <span class="qldh-trangthai-choduyet">⏳ Chờ duyệt</span>
      <?php endif; ?>
    </p>
    <p><strong>Người tạo đơn:</strong> <?= $row_donhang['ten_khach']; ?></p>
    <p><strong>Ghi chú:</strong> Giao hàng trong giờ hành chính</p>
    <p><strong>Tổng tiền:</strong> <span class="qldh-tongtien"><?= number_format($tongtien, 0, ',', '.') . 'đ'; ?></span></p>

    <?php
    if (isset($_POST['xacnhan'])) {
      $sql_update = "UPDATE donhang SET trangthai = 1 WHERE ma_giohang = '$code'";
      if (mysqli_query($mysqli, $sql_update)) {
        header("Location: indexad.php?action=quanlydonhang&query=xemdonhang&code=$code");
        exit;
      } else {
        echo "❌ Lỗi xác nhận đơn hàng: " . mysqli_error($mysqli);
      }
    }
    ?>

    <div class="qldh-nut-hanhdong">
      <button onclick="window.print()">🖨️ In hóa đơn</button>
      <?php if ($row_donhang['trangthai'] == 0): ?>
        <form method="POST">
          <input type="submit" name="xacnhan" value="✅ Xác nhận đơn hàng">
        </form>
      <?php else: ?>
        <p><em>✔️ Đơn hàng đã được xác nhận.</em></p>
      <?php endif; ?>
    </div>

    <table class="qldh-bang-sanpham">
      <thead>
        <tr>
          <th>Ảnh</th>
          <th>Sản phẩm</th>
          <th>Đơn giá</th>
          <th>Số lượng</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sanpham_rows as $sp): ?>
          <tr>
            <td><img src="modules/quanlysp/uploads/<?= $sp['hinhanh']; ?>" width="90"></td>
            <td><?= $sp['tensanpham']; ?></td>
            <td><?= number_format($sp['giasp'], 0, ',', '.') . 'đ'; ?></td>
            <td><?= $sp['soluong']; ?></td>
            <td><?= number_format($sp['thanhtien'], 0, ',', '.') . 'đ'; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
