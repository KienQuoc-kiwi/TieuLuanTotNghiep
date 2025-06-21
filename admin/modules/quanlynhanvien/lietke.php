<?php
    $sql_nhanvien = "SELECT * FROM nhanvien ";
    $query_nhanvien = mysqli_query($mysqli,$sql_nhanvien);
?>
<div class="bang-nhanvien">
  <table class="bang-nhanvien__table">
    <tr>
      <th class="bang-nhanvien__tieude">Mã nhân viên</th>
      <th class="bang-nhanvien__tieude">Tên nhân viên</th>
      <th class="bang-nhanvien__tieude">Giới tính</th>
      <th class="bang-nhanvien__tieude">Địa chỉ</th>
      <th class="bang-nhanvien__tieude">Điện thoại</th>
      <th class="bang-nhanvien__tieude"></th>
    </tr>
    <?php
        $i = 0;
        while($row = mysqli_fetch_array($query_nhanvien)){
            $i++;
    ?>
    <tr>
      <td class="bang-nhanvien__noidung"><?php echo $i ?></td>
      <td class="bang-nhanvien__noidung"><?php echo $row['hoten_nhanvien'] ?></td>
      <td class="bang-nhanvien__noidung"><?php echo $row['gioitinh'] ?></td>
      <td class="bang-nhanvien__noidung"><?php echo $row['diachi'] ?></td>
      <td class="bang-nhanvien__noidung"><?php echo $row['sodienthoai'] ?></td>
      <td class="bang-nhanvien__noidung">
        <a class="btn-nhanvien btn-xoa" href="modules/quanlynhanvien/xuly.php?Manv=<?php echo $row['id_nv'] ?>">Xóa</a> |
        <a class="btn-nhanvien btn-sua" href="?action=quanlynhanvien&query=sua&Manv=<?php echo $row['id_nv'] ?>">Sửa</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>