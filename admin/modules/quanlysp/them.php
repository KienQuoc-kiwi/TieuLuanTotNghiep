<div class="themdanhmuc">
    <!-- <p>Thêm sản phẩm mới</p> -->
    <form method="post" enctype="multipart/form-data" action="modules/quanlybienthe/xuly.php">
        <table>
            <tr>
                <td><strong>Tên sản phẩm</strong></td>
                <td><input type="text" name="tensanpham" required /></td>
            </tr>
            <tr>
                <td><strong>Mã sản phẩm</strong></td>
                <td><input type="text" name="masp" required /></td>
            </tr>
            <tr>
                <td><strong>Giá sản phẩm</strong></td>
                <td><input type="text" name="giasp" required /></td>
            </tr>
            <tr>
                <td><strong>Số lượng</strong></td>
                <td><input type="text" name="soluong" required /></td>
            </tr>
            <tr>
                <td><strong>Ảnh sản phẩm chính</strong></td>
                <td><input type="file" name="hinhanh" required /></td>
            </tr>
            <tr>
                <td><strong>Tóm tắt</strong></td>
                <td><textarea name="tomtat" rows="4"></textarea></td>
            </tr>
            <tr>
                <td><strong>Danh mục</strong></td>
                <td>
                    <select name="danhmuc">
                        <?php
                        $sql_danhmuc = "SELECT * FROM danhmuc ORDER BY id_danhmuc DESC";
                        $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                        ?>
                            <option value="<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Trạng thái</strong></td>
                <td>
                    <select name="tinhtrang">
                        <option value="1">Kích hoạt</option>
                        <option value="0">Ẩn</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>
        <!-- <h4></h4> -->
        <p>Thêm biến thể sản phẩm (Size + Màu + Số lượng + Ảnh)</p>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <tr>
                <th>Size</th>
                <th>Màu sắc</th>
                <th>Số lượng</th>
                <th>SKU</th>
                <th>Ảnh riêng</th>
            </tr>
            <?php for ($i = 0; $i < 5; $i++) { ?>
                <tr>
                    <td><input type="text" name="variants[<?php echo $i ?>][kichco]" placeholder="M, L, 42..." /></td>
                    <td><input type="text" name="variants[<?php echo $i ?>][mausac]" placeholder="Red, Black..." /></td>
                    <td><input type="number" name="variants[<?php echo $i ?>][soluongtonkho]" min="0" /></td>
                    <td><input type="text" name="variants[<?php echo $i ?>][madinhdanh]" placeholder="Tự động nếu trống" /></td>
                    <td><input type="file" name="variant_images[<?php echo $i ?>]" /></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" name="themsanpham" value="Thêm sản phẩm mới">
    </form>
</div>