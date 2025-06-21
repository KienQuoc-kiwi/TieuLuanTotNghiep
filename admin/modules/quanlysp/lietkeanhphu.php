<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../config/config.php');

// Kiểm tra kết nối
if (!$mysqli) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy id_sanpham từ URL nếu có, nếu không thì đặt về 0
$id_sanpham = isset($_GET['id_sanpham']) ? (int)$_GET['id_sanpham'] : 0;

?>
<div class="quanly-anhphu">
    <h2>Danh sách ảnh phụ <?php echo $id_sanpham > 0 ? "của sản phẩm ID: $id_sanpham" : ""; ?></h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="table-anhphu">
        <thead>
            <tr>
                <th>ID Ảnh</th>
                <th>Đường dẫn</th>
                <th>Thứ tự hiển thị</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Nếu có id_sanpham thì lọc theo sản phẩm, nếu không thì hiển thị tất cả
            if ($id_sanpham > 0) {
                $sql = "SELECT * FROM anhphu WHERE id_sanpham = ? ORDER BY thutu_hien_thi ASC";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
            } else {
                $sql = "SELECT * FROM anhphu ORDER BY id_anhphu DESC";
                $stmt = mysqli_prepare($mysqli, $sql);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_anhphu']); ?></td>
                        <td>
                            <?php
                            $duongdan = 'modules/quanlysp/' . $row['duong_dan']; // trở về gốc rồi mới vào thư mục chứa ảnh
                            if (file_exists($duongdan)):
                            ?>
                                <img src="<?php echo $duongdan; ?>" width="100" height="100" class="img-thumbnail">
                            <?php else: ?>
                                <span>Ảnh không tồn tại</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['thutu_hien_thi']); ?></td>
                        <td><?php echo htmlspecialchars($row['ngay_tao']); ?></td>
                        <td>
                            <a class="btn-sua" href="indexad.php?action=quanlyanhphu&query=suaanhphu&id_anhphu=<?php echo htmlspecialchars($row['id_anhphu']); ?>&id_sanpham=<?php echo $row['id_sanpham']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a class="btn-xoa" href="modules/quanlysp/xulyanhphu.php?query=xoa_anhphu&id_anhphu=<?php echo htmlspecialchars($row['id_anhphu']); ?>&id_sanpham=<?php echo $row['id_sanpham']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Không có ảnh phụ.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- <style>
    .table {
        width: 100%;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: center;
        vertical-align: middle;
    }

    .img-thumbnail {
        border: 1px solid #ddd;
        padding: 5px;
    }

    .alert {
        margin-bottom: 15px;
        padding: 10px;
    }

    .btn-sm {
        padding: 5px 10px;
    }
</style> -->