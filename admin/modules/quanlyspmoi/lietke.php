<?php
// include('../../config/config.php');
$sql_lietke_sp = "SELECT * from sanphammoi, danhmuc WHERE sanphammoi.id_danhmuc=danhmuc.id_danhmuc order by id_spmoi asc";
$query_lietke_sp = mysqli_query($mysqli, $sql_lietke_sp);
?>

<div class="lietke">
    <p>Liệt kê sản phẩm mới</p>
    <table style="width:100%" border="1" style="border-collapse: collapse;">
        <tr>
            <th>Id</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá sp</th>
            <th>số lượng</th>
            <th>danh mục</th>
            <th>Mã sp</th>
            <th>Tóm tắt</th>
            <th>Trạng thái</th>
            <th>Quản lý</th>
        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_sp)) {
            $i++;

        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tenspmoi'] ?></td>
                <td><img src="modules/quanlyspmoi/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
                <td><?php echo $row['giaspmoi'] ?></td>
                <td><?php echo $row['soluong'] ?></td>
                <td><?php echo $row['tendanhmuc'] ?></td>
                <td><?php echo $row['maspmoi'] ?></td>
                <td><?php echo $row['tomtat'] ?></td>
                <td>
                    <?php if ($row['tinhtrang'] == 1) { ?>
                        <span class="badge active">Kích hoạt</span>
                    <?php } else { ?>
                        <span class="badge inactive">Ẩn</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="modules/quanlyspmoi/xuly.php?id_spmoi=<?php echo $row['id_spmoi'] ?>" class="action-btn delete">Xóa</a> | <a href="
            ?action=quanlyspmoi&query=sua&id_spmoi=<?php echo $row['id_spmoi'] ?>" class="action-btn">Sửa</a>
                </td>
            </tr>
            <tr></tr>
        <?php
        }
        ?>
    </table>
</div>