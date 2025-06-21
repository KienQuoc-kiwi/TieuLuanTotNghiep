<?php
include('../config/config.php');

$id_sanpham = isset($_GET['id_sanpham']) ? (int)$_GET['id_sanpham'] : 0;
if ($id_sanpham > 0) {
    $sql = "SELECT id_sanpham, tensanpham, soluong FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    mysqli_stmt_close($stmt);
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}
?>

<div class="tonkho">
    <h2 class="tieude-dieuchinh-tonkho">Điều chỉnh tồn kho</h2>
    <form method="post" action="modules/quanlytonkho/xuly.php" class="form-dieuchinh-tonkho">
        <input type="hidden" name="id_sanpham" value="<?php echo $id_sanpham; ?>">
        <table class="bang-dieuchinh-tonkho">
            <tr>
                <td class="ten-truong-tonkho">Sản phẩm</td>
                <td class="gia-tri-truong-tonkho"><?php echo htmlspecialchars($row['tensanpham']); ?></td>
            </tr>
            <tr>
                <td class="ten-truong-tonkho">Tồn kho hiện tại</td>
                <td class="gia-tri-truong-tonkho"><?php echo $row['soluong']; ?></td>
            </tr>
            <tr>
                <td class="ten-truong-tonkho">Tồn kho mới</td>
                <td class="gia-tri-truong-tonkho">
                    <input type="number" name="soluong" value="<?php echo $row['soluong']; ?>" min="0" required>
                </td>
            </tr>
            <tr>
                <td class="ten-truong-tonkho">Lý do</td>
                <td class="gia-tri-truong-tonkho">
                    <textarea name="lydo" rows="3" required></textarea>
                </td>
            </tr>
        </table>
        <input type="submit" name="suatonkho" value="Cập nhật" class="nut-xacnhan-tonkho">
    </form>
</div>
