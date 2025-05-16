<?php

$sql_sua_danhmucsp = "SELECT * from danhmuc where id_danhmuc= '$_GET[id_danhmuc]' limit 1";
$query_sua_danhmucsp = mysqli_query($mysqli, $sql_sua_danhmucsp);
$dong = mysqli_fetch_array($query_sua_danhmucsp);
?>

<div class="suadanhmucsp">
    <p>Sửa danh mục sản phẩm</p>
    <form method="POST" action="modules/quanlydanhmucsp/xuly.php?id_danhmuc=<?php echo $_GET['id_danhmuc'] ?>">
        <table>
            <tr>
                <th colspan="2">Điền danh mục sản phẩm</th>
            </tr>
            <tr>
                <td>Tên danh mục</td>
                <td><input type="text" value="<?= $dong['tendanhmuc'] ?>" name="tendanhmuc"></td>
            </tr>
            <tr>
                <td>Thứ tự</td>
                <td><input type="text" value="<?= $dong['thutu'] ?>" name="thutu"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="suadanhmuc" value="Sửa danh mục sản phẩm"></td>
            </tr>
        </table>
    </form>
</div>