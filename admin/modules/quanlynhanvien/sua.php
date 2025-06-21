<?php
$sql_sua_nv = "SELECT * from nhanvien where id_nv = '$_GET[Manv]' limit 1";
$query_sua_nv = mysqli_query($mysqli, $sql_sua_nv);
?>
<p class="tieude-chucnang">Sửa nhân viên</p>
<div class="form-sua-nhanvien">
    <?php while ($row = mysqli_fetch_array($query_sua_nv)) { ?>
        <form method="POST" action="modules/quanlynhanvien/xuly.php?Manv=<?php echo $row['id_nv'] ?>">
            <table class="form-nhanvien__table">
                <tr>
                    <th>Họ tên</th>
                    <td><input type="text" name="Hoten" value="<?php echo $row['hoten_nhanvien'] ?>" /></td>
                </tr>
                <tr>
                    <th>Giới tính</th>
                    <td><input type="text" name="Gioitinh" value="<?php echo $row['gioitinh'] ?>" /></td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td><input type="text" name="Diachi" value="<?php echo $row['diachi'] ?>" /></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><input type="text" name="sdt" value="<?php echo $row['sodienthoai'] ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn-nhanvien btn-sua" type="submit" name="suanhanvien" value="Sửa nhân viên" /></td>
                </tr>
            </table>
        </form>
    <?php } ?>
</div>