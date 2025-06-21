<?php
$sql_sua_kh = "SELECT * FROM khachhang WHERE id_khach = '$_GET[Makh]' LIMIT 1";
$query_sua_kh = mysqli_query($mysqli, $sql_sua_kh);
?>
<p class="tieude-chucnang">Sửa khách hàng</p>
<div class="form-sua-khachhang">
    <?php while ($row = mysqli_fetch_array($query_sua_kh)) { ?>
        <form method="POST" action="modules/quanlykhach/xuly.php?Makh=<?php echo $row['id_khach'] ?>">
            <table class="form-khachhang__table">
                <tr>
                    <th>Tên khách hàng</th>
                    <td><input type="text" name="Tenkhach" value="<?php echo $row['ten_khach'] ?>" /></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><input type="text" name="Username" value="<?php echo $row['username'] ?>" /></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><input type="text" name="Password" value="<?php echo $row['password'] ?>" /></td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td><input type="text" name="Diachi" value="<?php echo $row['diachi'] ?>" /></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><input type="text" name="sdt" value="<?php echo $row['dienthoai'] ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn-khachhang btn-sua" type="submit" name="suakhachhang" value="Sửa khách hàng" /></td>
                </tr>
            </table>
        </form>
    <?php } ?>
</div>