<?php include('../config/config.php'); ?>
<div class="them-anhphu">
    <h2>Thêm ảnh phụ cho sản phẩm</h2>
    <form method="post" enctype="multipart/form-data" action="modules/quanlysp/xulyanhphu.php">
        <div class="mb-3">
            <label for="id_sanpham" class="form-label"><strong>Chọn sản phẩm:</strong></label>
            <select name="id_sanpham" id="id_sanpham" class="form-control" required>
                <option value="">-- Chọn sản phẩm --</option>
                <?php
                $sql_sanpham = "SELECT id_sanpham, tensanpham FROM sanpham ORDER BY id_sanpham DESC";
                $query_sanpham = mysqli_query($mysqli, $sql_sanpham);
                while ($row_sanpham = mysqli_fetch_array($query_sanpham)) {
                    echo '<option value="' . htmlspecialchars($row_sanpham['id_sanpham']) . '">' . htmlspecialchars($row_sanpham['tensanpham']) . ' (ID: ' . htmlspecialchars($row_sanpham['id_sanpham']) . ')</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="hinhanh_phu" class="form-label"><strong>Chọn ảnh phụ:</strong></label>
            <input type="file" name="hinhanh_phu[]" class="form-control" multiple accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="thutu_hien_thi" class="form-label"><strong>Thứ tự hiển thị:</strong></label>
            <input type="number" name="thutu_hien_thi" class="form-control" min="0" value="0" required>
        </div>
        <input type="submit" name="them_anhphu" value="Thêm ảnh phụ" class="btn btn-primary">
    </form>
</div>

<!-- <style>
    .form-label { font-weight: bold; }
    .form-control { width: 100%; padding: 8px; margin-bottom: 10px; }
    .btn-primary { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; }
    .btn-primary:hover { background-color: #0056b3; }
</style> -->