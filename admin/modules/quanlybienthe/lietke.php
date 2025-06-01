<?php
$sql_lietke_sp = "SELECT id_bienthe, kichco, mausac, soluongtonkho, madinhdanh, hinhanh FROM bienthesanpham";
$query_lietke_sp = mysqli_query($mysqli, $sql_lietke_sp);
?>

<div class="lietke">
    <p>Liệt kê biến thể sản phẩm</p>
    <table style="width:100%" border="1" style="border-collapse: collapse;">
        <tr>
            <th>STT</th>
            <th>Kích cỡ</th>
            <th>Màu sắc</th>
            <th>Số lượng</th>
            <th>Mã sku</th>
            <th>Hình ảnh</th>
            <th>Quản lý</th>
        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_sp)) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($row['kichco']) ?></td>
                <td><?php echo htmlspecialchars($row['mausac']) ?></td>
                <td><?php echo htmlspecialchars($row['soluongtonkho']) ?></td>
                <td><?php echo htmlspecialchars($row['madinhdanh']) ?></td>
                <td>
                    <img src="modules/quanlybienthe/uploads/<?php echo htmlspecialchars($row['hinhanh']) ?>" width="100px">
                </td>
                <td>
                    <a href="modules/quanlybienthe/xuly.php?id_bienthe=<?php echo $row['id_bienthe'] ?>" class="action-btn delete">Xóa</a> |
                    <a href="?action=quanlybienthe&query=sua&id_bienthe=<?php echo $row['id_bienthe'] ?>" class="action-btn">Sửa</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
