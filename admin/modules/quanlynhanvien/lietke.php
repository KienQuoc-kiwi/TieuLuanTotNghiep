<?php
    $sql_lietke_nv = "SELECT * FROM nhanvien ";
    $query_lietke_nv = mysqli_query($mysqli,$sql_lietke_nv);

?>
<div class="lietkenv">
<table >
    <tr>
        <th>Mã nhân viên</th>
        <th>Tên nhân viên</th>
        <th>Giới tính</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
    </tr>
    <?php
        $i = 0;
        while($row = mysqli_fetch_array($query_lietke_nv)){
            $i++;

    ?>
    
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['hoten_nhanvien'] ?></td>
        <td><?php echo $row['gioitinh'] ?></td>
        <td><?php echo $row['diachi'] ?></td>
        <td><?php echo $row['sodienthoai'] ?></td>
        <td>
            <a href="modules/quanlynhanvien/xuly.php?Manv=<?php echo $row['id_nv'] ?>">Xóa</a> | <a href="
            ?action=quanlynhanvien&query=sua&Manv=<?php echo $row['id_nv'] ?>">Sửa</a>
        </td>
    </tr>
    <?php
        }
    ?>
</table>
</div>
