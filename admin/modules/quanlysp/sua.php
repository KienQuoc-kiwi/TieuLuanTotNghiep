<?php include('../config/config.php'); ?>
<?php
if (isset($_GET['id_sanpham'])) {
    $id_sanpham = (int)$_GET['id_sanpham'];
    $sql_sua = "SELECT * FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt_sua = mysqli_prepare($mysqli, $sql_sua);
    mysqli_stmt_bind_param($stmt_sua, "i", $id_sanpham);
    mysqli_stmt_execute($stmt_sua);
    $result_sua = mysqli_stmt_get_result($stmt_sua);
    $row_sua = mysqli_fetch_array($result_sua);
    mysqli_stmt_close($stmt_sua);
}
?>
<div class="quanly-sp">
    <h2 class="tieude-sua-sp">Sửa sản phẩm</h2>
    <form method="post" enctype="multipart/form-data" action="modules/quanlysp/xuly.php?id_sanpham=<?php echo $id_sanpham; ?>" class="form-sua-sp">
        <input type="hidden" name="id_sanpham" value="<?php echo $id_sanpham; ?>">
        <table class="bang-sua-sp">
            <tr>
                <td class="ten-truong"><strong>Tên sản phẩm</strong></td>
                <td class="gia-tri-truong"><input type="text" name="tensanpham" value="<?php echo htmlspecialchars($row_sua['tensanpham']); ?>" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Mã sản phẩm</strong></td>
                <td class="gia-tri-truong"><input type="text" name="masp" value="<?php echo htmlspecialchars($row_sua['masp']); ?>" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Giá sản phẩm</strong></td>
                <td class="gia-tri-truong"><input type="number" name="giasp" value="<?php echo $row_sua['giasp']; ?>" min="0" step="0.01" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Số lượng</strong></td>
                <td class="gia-tri-truong"><input type="number" name="soluong" value="<?php echo $row_sua['soluong']; ?>" min="0" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Ảnh sản phẩm hiện tại</strong></td>
                <td class="gia-tri-truong">
                    <?php if ($row_sua['hinhanh']) echo '<img src="modules/quanlysp/uploads/' . htmlspecialchars($row_sua['hinhanh']) . '" width="100" />'; ?>
                    <input type="file" name="hinhanh" accept="image/*" />
                </td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Tóm tắt</strong></td>
                <td class="gia-tri-truong"><textarea name="tomtat" rows="4"><?php echo htmlspecialchars($row_sua['tomtat']); ?></textarea></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Danh mục</strong></td>
                <td class="gia-tri-truong">
                    <select name="danhmuc" id="danhmuc-sua" required onchange="loadSubcategories()">
                        <option value="">Chọn danh mục</option>
                        <?php
                        $sql_danhmuc = "SELECT * FROM danhmuc ORDER BY id_danhmuc DESC";
                        $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                            $selected = ($row_danhmuc['id_danhmuc'] == $row_sua['id_danhmuc']) ? 'selected' : '';
                            echo '<option value="' . $row_danhmuc['id_danhmuc'] . '" ' . $selected . '>' . htmlspecialchars($row_danhmuc['tendanhmuc']) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Danh mục con</strong></td>
                <td class="gia-tri-truong">
                    <select name="danhmuccon" id="danhmuccon-sua">
                        <option value="">Chọn danh mục con</option>
                        <?php
                        if ($row_sua['id_danhmuc']) {
                            $sql_danhmuccon = "SELECT id_danhmuccon, ten_danhmuccon FROM danhmuccon WHERE id_danhmuc = ? ORDER BY id_danhmuccon DESC";
                            $stmt_danhmuccon = mysqli_prepare($mysqli, $sql_danhmuccon);
                            mysqli_stmt_bind_param($stmt_danhmuccon, "i", $row_sua['id_danhmuc']);
                            mysqli_stmt_execute($stmt_danhmuccon);
                            $result_danhmuccon = mysqli_stmt_get_result($stmt_danhmuccon);
                            while ($row_danhmuccon = mysqli_fetch_array($result_danhmuccon)) {
                                $selected = ($row_danhmuccon['id_danhmuccon'] == $row_sua['id_danhmuccon']) ? 'selected' : '';
                                echo '<option value="' . $row_danhmuccon['id_danhmuccon'] . '" ' . $selected . '>' . htmlspecialchars($row_danhmuccon['ten_danhmuccon']) . '</option>';
                            }
                            mysqli_stmt_close($stmt_danhmuccon);
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Trạng thái</strong></td>
                <td class="gia-tri-truong">
                    <select name="tinhtrang" required>
                        <option value="1" <?php echo ($row_sua['tinhtrang'] == 1) ? 'selected' : ''; ?>>Kích hoạt</option>
                        <option value="0" <?php echo ($row_sua['tinhtrang'] == 0) ? 'selected' : ''; ?>>Ẩn</option>
                    </select>
                </td>
            </tr>
        </table>
        <br><br>
        <input type="submit" name="suasanpham" value="Sửa sản phẩm" class="nut-xac-nhan">
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadSubcategories() {
    const id_danhmuc = $('#danhmuc').val();
    if (!id_danhmuc) {
        $('#danhmuccon').html('<option value="">Chọn danh mục con</option>');
        return;
    }
    $.ajax({
        url: 'modules/quanlysp/get_subcategories.php',
        type: 'POST',
        data: { id_danhmuc: id_danhmuc },
        dataType: 'json',
        success: function(data) {
            const subcategorySelect = $('#danhmuccon');
            subcategorySelect.html('<option value="">Chọn danh mục con</option>');
            if (data.length > 0) {
                data.forEach(sub => {
                    subcategorySelect.append(`<option value="${sub.id_danhmuccon}">${sub.ten_danhmuccon}</option>`);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
            // alert('Lỗi khi tải danh mục con.');
        }
    });
}
$(document).ready(function() {
    loadSubcategories(); // Load subcategories on page load
});
</script>

<style>
    table { width: 100%; border-collapse: collapse; }
    table td { padding: 10px; }
    input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 5px; }
    input[type="submit"] { padding: 10px 20px; }
</style>