<?php
include('../config/config.php');
$id = $_GET['id'];
$sql = "SELECT * FROM bienthesanpham WHERE id_bienthe=$id";
$row = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
?>
<div class="container-bienthe">
  <h3>Sửa biến thể</h3>
  <form class="bienthe-form" method="POST" action="modules/quanlybienthe/xulybienthe.php" enctype="multipart/form-data">
    <input type="hidden" name="id_bienthe" value="<?php echo $id; ?>">
    <input type="hidden" name="id_sanpham" value="<?php echo $row['id_sanpham']; ?>">
    <label>Kích cỡ</label><input type="text" name="kichco" value="<?php echo $row['kichco']; ?>">
    <label>Màu sắc</label><input type="text" name="mausac" value="<?php echo $row['mausac']; ?>">
    <label>Số lượng</label><input type="number" name="soluongtonkho" value="<?php echo $row['soluongtonkho']; ?>">
    <label>Mã định danh</label><input type="text" name="madinhdanh" value="<?php echo $row['madinhdanh']; ?>">
    <label>Ảnh</label><input type="file" name="hinhanh">
    <img class="bienthe-img" src="bientheuploads/<?php echo $row['hinhanh']; ?>" width="60">
    <input type="submit" name="sua_bienthe" value="Cập nhật">
  </form>
</div>