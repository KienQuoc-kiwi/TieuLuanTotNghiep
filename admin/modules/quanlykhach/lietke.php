<?php
    $sql_khachhang = "SELECT * FROM khachhang";
    $query_khachhang = mysqli_query($mysqli, $sql_khachhang);
?>
<div class="bang-khachhang">
    <h2>Quản lý khách hàng</h2>
  <table class="bang-khachhang__table">
    <tr>
      <th class="bang-khachhang__tieude">Mã khách hàng</th>
      <th class="bang-khachhang__tieude">Tên khách hàng</th>
      <th class="bang-khachhang__tieude">Địa chỉ</th>
      <th class="bang-khachhang__tieude">Điện thoại</th>
      <th class="bang-khachhang__tieude"></th>
    </tr>
    <?php
        $i = 0;
        while($row = mysqli_fetch_array($query_khachhang)){
            $i++;
    ?>
    <tr>
      <td class="bang-khachhang__noidung"><?php echo $i ?></td>
      <td class="bang-khachhang__noidung"><?php echo $row['ten_khach'] ?></td>
      <td class="bang-khachhang__noidung"><?php echo $row['diachi'] ?></td>
      <td class="bang-khachhang__noidung"><?php echo $row['dienthoai'] ?></td>
      <td class="bang-khachhang__noidung">
        <a class="btn-khachhang btn-xoa" href="modules/quanlykhach/xuly.php?Makh=<?php echo $row['id_khach'] ?>">Xóa</a> |
        <a class="btn-khachhang btn-sua" href="?action=quanlykhach&query=sua&Makh=<?php echo $row['id_khach'] ?>">Sửa</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>