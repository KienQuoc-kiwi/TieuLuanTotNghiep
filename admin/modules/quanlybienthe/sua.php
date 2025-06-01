<?php
// Lấy biến thể cần sửa
$sql_sua_bienthe = "SELECT * FROM bienthesanpham WHERE id_bienthe = '$_GET[id_bienthe]' LIMIT 1";
$query_sua_bienthe = mysqli_query($mysqli, $sql_sua_bienthe);
?>

<div class="suasanpham">
    <p>Sửa biến thể sản phẩm</p>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <?php
        while ($row = mysqli_fetch_array($query_sua_bienthe)) {
        ?>
            <form method="POST" action="modules/quanlybienthe/xuly.php?id_bienthe=<?php echo $row['id_bienthe'] ?>" enctype="multipart/form-data">
                <tr>
                    <th>Kích cỡ</th>
                    <td><input type="text" value="<?php echo $row['kichco'] ?>" name="kichco"></td>
                </tr>
                <tr>
                    <th>Màu sắc</th>
                    <td><input type="text" value="<?php echo $row['mausac'] ?>" name="mausac"></td>
                </tr>
                <tr>
                    <th>Số lượng tồn kho</th>
                    <td><input type="number" value="<?php echo $row['soluongtonkho'] ?>" name="soluongtonkho" min="0"></td>
                </tr>
                <tr>
                    <th>Mã định danh (SKU)</th>
                    <td><input type="text" value="<?php echo $row['madinhdanh'] ?>" name="madinhdanh"></td>
                </tr>
                <tr>
                    <th>Hình ảnh</th>
                    <td>
                        <input type="file" name="hinhanh">
                        <br>
                        <img src="modules/quanlybienthe/uploads/<?php echo $row['hinhanh'] ?>" width="120px">
                    </td>
                </tr>
                <tr>
                    <th>Thuộc sản phẩm</th>
                    <td>
                        <select name="id_sanpham">
                            <?php
                            $sql_sp = "SELECT * FROM sanpham ORDER BY id_sanpham DESC";
                            $query_sp = mysqli_query($mysqli, $sql_sp);
                            while ($sp = mysqli_fetch_array($query_sp)) {
                                if ($sp['id_sanpham'] == $row['id_sanpham']) {
                            ?>
                                    <option selected value="<?php echo $sp['id_sanpham'] ?>"><?php echo $sp['tensanpham'] ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $sp['id_sanpham'] ?>"><?php echo $sp['tensanpham'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="suabienthe" value="Cập nhật biến thể"></td>
                </tr>
            </form>
        <?php
        }
        ?>
    </table>
</div>
