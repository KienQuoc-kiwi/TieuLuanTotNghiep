<?php
// include('../../config/config.php');
$sql_lietke_danhmucsp = "SELECT * from danhmuc order by thutu asc";
$query_lietke_danhmucsp = mysqli_query($mysqli, $sql_lietke_danhmucsp);
?>
<div class="lietkedanhmuc">
    <p>Liệt kê sản phẩm</p>
    <table style="width:100%" border="1" style="border-collapse: collapse;">
        <tr>
            <th>Id</th>
            <th>Tên danh mục</th>
            <th>Quản lý</th>
        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_danhmucsp)) {
            $i++;

        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tendanhmuc'] ?></td>
                <td>
                    <a href="modules/quanlydanhmucsp/xuly.php?id_danhmuc=<?php echo $row['id_danhmuc'] ?>">Xóa</a> | <a href="
            ?action=quanlydanhmucsanpham&query=sua&id_danhmuc=<?php echo $row['id_danhmuc'] ?>">Sửa</a>
                </td>
            </tr>
            <tr></tr>
        <?php
        }
        ?>
    </table>
</div>