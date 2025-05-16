<?php

$sql_sua_nv = "SELECT * from nhanvien where id_nv = '$_GET[Manv]' limit 1";
$query_sua_nv = mysqli_query($mysqli, $sql_sua_nv);
// $dong = mysqli_fetch_array($query_sua_sp);
?>
<p>Sửa nhân viên</p>
<div class="suanv">
    <?php
    while ($row = mysqli_fetch_array($query_sua_nv)) {
    ?>
        <form method="POST" action="modules/quanlynhanvien/xuly.php?Manv=<?php echo $row['id_nv'] ?>" enctype="multipart/form-data">
            <table>


                <tr>
                    <th>Tên nhân viên</th>
                    <td><input type="text" value="<?php echo $row['hoten_nhanvien'] ?>" name="Hoten"></td>
                </tr>

                <tr>
                    <td>Giới tính</td>
                    <td><input type="text" value="<?php echo $row['gioitinh'] ?>" name="Gioitinh"></td>
                </tr>
                <tr>
                    <td>Địa chỉ</td>
                    <td><input type="text" value="<?php echo $row['diachi'] ?>" name="Diachi"></td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td><input type="text" value="<?php echo $row['sodienthoai'] ?>" name="sdt"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="suanhanvien" value="Sửa Nhân viên"></td>
                </tr>

            <?php
        }
            ?>
            </table>
        </form>
</div>