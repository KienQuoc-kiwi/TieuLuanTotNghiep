<?php
// include('../../config/config.php');
$sql_lietke_danhmucsp = "SELECT * from danhmuc order by thutu asc";
$query_lietke_danhmucsp = mysqli_query($mysqli, $sql_lietke_danhmucsp);
?>
<div class="quanly-danhmuc">
    <p>Liệt kê danh mục sản phẩm</p>
    <table class="bang-danhmuc">
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
                <td class="nut-danhmuc">
                    <a href="modules/quanlydanhmucsp/xuly.php?id_danhmuc=<?php echo $row['id_danhmuc'] ?>">Xóa</a> |
                    <a href="?action=quanlydanhmucsanpham&query=sua&id_danhmuc=<?php echo $row['id_danhmuc'] ?>">Sửa</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<style>
    .nut-danhmuc a {
    color:rgb(249, 250, 250); /* xanh dương nổi bật */
    text-decoration: none;
    margin: 0 4px;
    font-weight: 500;
    background-color: #343A40;
}

.nut-danhmuc a:hover {
    text-decoration: underline;
    color:rgb(202, 77, 10);
}
</style>
