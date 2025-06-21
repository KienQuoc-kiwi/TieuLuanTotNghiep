<?php
include('../config/config.php');

$sql_sp = "SELECT id_sanpham, tensanpham FROM sanpham";
$query_sp = mysqli_query($mysqli, $sql_sp);
?>
<div class="container-bienthe">
  <h3>Thêm biến thể sản phẩm</h3>
  <form class="bienthe-form" method="POST" action="modules/quanlybienthe/xulybienthe.php" enctype="multipart/form-data">
    <table>
      <tr>
        <td>Sản phẩm</td>
        <td>
          <select name="id_sanpham" required>
            <option value="">--Chọn sản phẩm--</option>
            <?php while ($row = mysqli_fetch_array($query_sp)) { ?>
              <option value="<?php echo $row['id_sanpham']; ?>"><?php echo $row['tensanpham']; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Kích cỡ (dạng 42,43,44)</td>
        <td><input type="text" name="kichco[]" required></td>
      </tr>
      <tr>
        <td>Màu sắc</td>
        <td><input type="text" name="mausac[]" required></td>
      </tr>
      <tr>
        <td>Số lượng tồn kho</td>
        <td><input type="number" name="soluongtonkho[]" required></td>
      </tr>
      <tr>
        <td>Mã định danh</td>
        <td><input type="text" name="madinhdanh[]" required></td>
      </tr>
      <tr>
        <td>Ảnh màu (ảnh đại diện)</td>
        <td><input type="file" name="hinhanh[]" required></td>
      </tr>
    </table>
    <button type="button" onclick="addRow()">+ Thêm hàng</button>
    <input type="submit" name="them_bienthe" value="Thêm biến thể">
  </form>
</div>

<script>
function addRow() {
  const form = document.querySelector("form table");
  const row = `
    <tr><td colspan='2'><hr></td></tr>
    <tr><td>Kích cỡ</td><td><input type='text' name='kichco[]' required></td></tr>
    <tr><td>Màu sắc</td><td><input type='text' name='mausac[]' required></td></tr>
    <tr><td>Số lượng tồn kho</td><td><input type='number' name='soluongtonkho[]' required></td></tr>
    <tr><td>Mã định danh</td><td><input type='text' name='madinhdanh[]' required></td></tr>
    <tr><td>Ảnh màu</td><td><input type='file' name='hinhanh[]' required></td></tr>
  `;
  form.insertAdjacentHTML('beforeend', row);
}
</script>