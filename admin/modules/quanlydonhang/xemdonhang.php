<?php
$code = $_GET['code']; // mã đơn hàng (ma_giohang)

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

$query_donhang = mysqli_query($mysqli, $sql_donhang);
$row_donhang = mysqli_fetch_array($query_donhang);

// Lấy chi tiết sản phẩm trong đơn
$sql_chitiet = "
    SELECT sanpham.tensanpham, sanpham.giasp, sanpham.hinhanh, 
           chitietdonhang.soluong
    FROM chitietdonhang 
    JOIN sanpham ON chitietdonhang.id_sanpham = sanpham.id_sanpham 
    WHERE chitietdonhang.ma_giohang = '$code'
";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);

// Tính tổng tiền
$tongtien = 0;
?>
<div class="xemdonhang">
  <!-- Thông tin tổng quát -->
  <div class="thongtindon">
    <h2>Chi tiết đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> <?php echo $row_donhang['ma_giohang']; ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?php echo date("d/m/Y", strtotime($row_donhang['ngaytao'])); ?></p>
    <p><strong>Trạng thái:</strong> <?php echo $row_donhang['trangthai']; ?></p>
    <p><strong>Người tạo đơn:</strong> <?php echo $row_donhang['ten_khach']; ?></p>
    <p><strong>Ghi chú:</strong> Giao hàng trong giờ hành chính</p>

    <?php
    // Tính tổng tiền trước khi hiển thị
    while ($row = mysqli_fetch_array($query_chitiet)) {
      $thanhtien = $row['giasp'] * $row['soluong'];
      $tongtien += $thanhtien;
      $sanpham_rows[] = $row + ['thanhtien' => $thanhtien]; // lưu lại để hiển thị bảng bên dưới
    }
    ?>
    <p><strong>Tổng tiền:</strong> <span class="tongtien"><?php echo number_format($tongtien, 0, ',', '.') . 'đ'; ?></span></p>

    <!-- Nút hành động -->
    <div class="btn-group">
      <button onclick="window.print()">🖨️ In hóa đơn</button>
      <form method="POST" action="">
        <input type="submit" name="xacnhan" value="✅ Xác nhận đơn hàng">
      </form>
    </div>
  </div>

  <!-- Bảng sản phẩm -->
  <table>
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
          <td><img src="modules/quanlysp/uploads/<?php echo $sp['hinhanh']; ?>" width="90"></td>
          <td><?php echo $sp['tensanpham']; ?></td>
          <td><?php echo number_format($sp['giasp'], 0, ',', '.') . 'đ'; ?></td>
          <td><?php echo $sp['soluong']; ?></td>
          <td><?php echo number_format($sp['thanhtien'], 0, ',', '.') . 'đ'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>