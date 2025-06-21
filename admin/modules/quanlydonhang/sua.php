<?php
$code = $_GET['code'];
$sql = "SELECT * FROM donhang WHERE ma_giohang = '$code' LIMIT 1";
$query = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_array($query);
?>

<form action="modules/quanlydonhang/xuly.php" method="POST" class="qldh-edit-form">
    <input type="hidden" name="ma_giohang" value="<?= $row['ma_giohang'] ?>">
    <label>Ngày tạo:</label>
    <input type="text" name="ngaytao" value="<?= $row['ngaytao'] ?>">
    <label>Ghi chú:</label>
    <textarea name="ghichu"><?= $row['ghichu'] ?? '' ?></textarea>
    <input type="submit" name="suadonhang" value="Cập nhật">
</form>
