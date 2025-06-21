<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../config/config.php');

$id_anhphu = isset($_GET['id_anhphu']) ? (int)$_GET['id_anhphu'] : 0;
$id_sanpham = isset($_GET['id_sanpham']) ? (int)$_GET['id_sanpham'] : 0;

if ($id_anhphu <= 0 || $id_sanpham <= 0) {
    $_SESSION['error'] = "ID không hợp lệ.";
    header('Location: indexad.php?action=quanlysp&query=lietkeanhphu&id_sanpham=' . $id_sanpham);
    exit;
}

$sql = "SELECT * FROM anhphu WHERE id_anhphu = ? LIMIT 1";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_anhphu);
mysqli_stmt_execute($stmt);
$anhphu = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$anhphu) {
    $_SESSION['error'] = "Ảnh phụ không tồn tại.";
    header('Location: indexad.php?action=quanlysp&query=lietkeanhphu&id_sanpham=' . $id_sanpham);
    exit;
}
?>

<div class="sua-anhphu">
    <h2>Sửa ảnh phụ</h2>
    <form method="post" action="modules/quanlysp/xulyanhphu.php" enctype="multipart/form-data">
        <input type="hidden" name="id_anhphu" value="<?php echo htmlspecialchars($id_anhphu); ?>">
        <input type="hidden" name="id_sanpham" value="<?php echo htmlspecialchars($id_sanpham); ?>">
        <div class="mb-3">
            <label class="form-label">Đường dẫn hiện tại:</label>
            <?php if (file_exists('admin/' . $anhphu['duong_dan'])): ?>
                <img src="admin/<?php echo htmlspecialchars($anhphu['duong_dan']); ?>" width="100" height="100" class="img-thumbnail">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="hinhanh_phu" class="form-label"><strong>Cập nhật ảnh phụ:</strong></label>
            <input type="file" name="hinhanh_phu" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="thutu_hien_thi" class="form-label"><strong>Thứ tự hiển thị:</strong></label>
            <input type="number" name="thutu_hien_thi" class="form-control" min="0" value="<?php echo htmlspecialchars($anhphu['thutu_hien_thi']); ?>" required>
        </div>
        <button type="submit" name="sua_anhphu" class="btn btn-primary">Cập nhật ảnh phụ</button>
        <!-- <a href="indexad.php?action=quanlysp&query=lietkeanhphu&id_sanpham=<?php echo $id_sanpham; ?>" class="btn btn-secondary">Quay lại</a> -->
    </form>
</div>

<style>
    .form-label { font-weight: bold; }
    .form-control { width: 100%; padding: 8px; }
    .img-thumbnail { border: 1px solid #ddd; padding: 5px; }
    .btn { padding: 10px 20px; margin-right: 10px; }
    .btn-primary { background-color: #007bff; color: white; border: none; border-radius: 5px; }
    .btn-primary:hover { background-color: #0056b3; }
    .btn-secondary { background-color: #6c757d; color: white; border: none; border-radius: 5px; }
    .btn-secondary:hover { background-color: #5a6268; }
</style>