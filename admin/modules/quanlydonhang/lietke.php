<?php
$sql_lietke_dh = "SELECT donhang.id_khach as idkhach, donhang.ma_giohang, khachhang.ten_khach, khachhang.username, khachhang.diachi, khachhang.dienthoai, ngaytao FROM donhang, khachhang WHERE donhang.id_khach=khachhang.id_khach
    ORDER BY donhang.id_giohang DESC";
$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

?>
<div class="qldh-lietke-wrapper">
    <table class="qldh-lietke-table">
        <h2>Danh Sách Đơn Hàng</h2>
        <tr>
            <th>ID</th>
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Ngày tạo</th>
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
                <td><?php echo $row['ngaytao'] ?></td>
                <td class="qldh-action-links">
                    <a class="qldh-btn qldh-xem" href="indexad.php?action=quanlydonhang&query=xemdonhang&code=<?php echo $row['ma_giohang'] ?>">Xem</a> |
                    <a class="qldh-btn qldh-sua" href="indexad.php?action=quanlydonhang&query=sua&code=<?php echo $row['ma_giohang'] ?>">Sửa</a> |
                    <a class="qldh-btn qldh-xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')"
                        href="modules/quanlydonhang/xuly.php?xoa=1&code=<?php echo $row['ma_giohang'] ?>">Xóa</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>