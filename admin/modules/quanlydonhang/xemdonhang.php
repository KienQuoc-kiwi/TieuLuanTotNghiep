<p>Xem đơn hàng</p>
<?php
$code = $_GET['code'];
$sql_lietke_dh = "SELECT id_chitietdonhang, chitietdonhang.ma_giohang AS madonhang, sanpham.tensanpham, chitietdonhang.soluong AS soluongmua, sanpham.giasp FROM chitietdonhang, sanpham WHERE chitietdonhang.id_sanpham=sanpham.id_sanpham
AND chitietdonhang.ma_giohang ='" . $code . "' ORDER BY chitietdonhang.id_chitietdonhang DESC";
$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

?>
<div class="xemdonhang">
    <table >
        <tr>
            <th>Id</th>
            <th>Mã đơn hàng</th>
            <th>Tên sản phẩm</th>
            <th>số lượng</th>
            <th>đơn giá</th>
            <th>thành tiền</th>
        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_dh)) {
            $i++;

        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['madonhang'] ?></td>
                <td><?php echo $row['tensanpham'] ?></td>
                <td><?php echo $row['soluongmua'] ?></td>
                <td><?php echo number_format($row['giasp'], 0, ',', '.') . 'vnđ' ?></td>
                <td><?php echo number_format($row['soluongmua'] * $row['giasp'], 0, ',', '.') . 'vnđ' ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>