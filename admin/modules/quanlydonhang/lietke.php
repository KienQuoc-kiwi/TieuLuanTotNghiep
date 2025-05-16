<?php
$sql_lietke_dh = "SELECT donhang.id_khach as idkhach, donhang.ma_giohang, khachhang.ten_khach, khachhang.username, khachhang.diachi, khachhang.dienthoai FROM donhang, khachhang WHERE donhang.id_khach=khachhang.id_khach
    ORDER BY donhang.id_giohang DESC";
$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

?>
<div class="lietkedonhang">
    <table >
        <tr>
            <th>Id</th>
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Quản lý</th>
        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_dh)) {
            $i++;

        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['ma_giohang'] ?></td>
                <td><?php echo $row['ten_khach'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['diachi'] ?></td>
                <td><?php echo $row['dienthoai'] ?></td>
                <td>
                    <a href="indexad.php?action=donhang&query=xemdonhang&code=<?php echo $row['ma_giohang'] ?>">Xem đơn hàng</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>