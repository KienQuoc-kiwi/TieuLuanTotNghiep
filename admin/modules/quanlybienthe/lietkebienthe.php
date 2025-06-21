<?php
include('../config/config.php');

// Lấy id_sanpham nếu có, nếu không thì = 0 (hiển thị toàn bộ)
$id_sanpham = isset($_GET['id_sanpham']) ? (int)$_GET['id_sanpham'] : 0;

// Truy vấn theo id_sanpham nếu có, không thì lấy tất cả
if ($id_sanpham > 0) {
    $sql = "SELECT * FROM bienthesanpham WHERE id_sanpham = $id_sanpham ORDER BY id_bienthe DESC";
} else {
    $sql = "SELECT * FROM bienthesanpham ORDER BY id_bienthe DESC";
}
$query = mysqli_query($mysqli, $sql);
?>

<div class="container-bienthe">
  <h3>Danh sách biến thể <?php echo $id_sanpham > 0 ? "(Sản phẩm ID: $id_sanpham)" : ""; ?></h3>
  <!-- <a href="thembienthe.php">+ Thêm biến thể</a> -->
  <table class="bienthe-table">
    <tr>
      <th>ID</th>
      <th>ID Sản phẩm</th>
      <th>Kích cỡ</th>
      <th>Màu sắc</th>
      <th>Số lượng</th>
      <th>Định danh</th>
      <th>Ảnh</th>
      <th>Hành động</th>
    </tr>
    <?php while ($row = mysqli_fetch_array($query)) { ?>
    <tr>
      <td><?php echo $row['id_bienthe']; ?></td>
      <td><?php echo $row['id_sanpham']; ?></td>
      <td><?php echo $row['kichco']; ?></td>
      <td><?php echo $row['mausac']; ?></td>
      <td><?php echo $row['soluongtonkho']; ?></td>
      <td><?php echo $row['madinhdanh']; ?></td>
      <td>
        <img src="modules/quanlybienthe/bientheuploads/<?php echo $row['hinhanh']; ?>" width="100" height="100">
      </td>
      <td>
        <a href="indexad.php?action=quanlybienthe&query=sua&id=<?php echo $row['id_bienthe']; ?>">Sửa</a> |
        <a href="modules/quanlybienthe/xulybienthe.php?query=xoa&id_bienthe=<?php echo $row['id_bienthe']; ?>&id_sanpham=<?php echo $row['id_sanpham']; ?>" onclick="return confirm('Xóa biến thể?')">Xóa</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
