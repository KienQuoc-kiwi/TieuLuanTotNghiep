<?php
include("config/config.php");

if (isset($_GET['id'])) {
    $id_sanpham = intval($_GET['id']);

    // Lấy thông tin sản phẩm
    $sql_sanpham = "SELECT * FROM sanpham WHERE id_sanpham = ?";
    $stmt = $mysqli->prepare($sql_sanpham);
    $stmt->bind_param("i", $id_sanpham);
    $stmt->execute();
    $result_sanpham = $stmt->get_result();
    $row_sanpham = $result_sanpham->fetch_assoc();
    $stmt->close();

    // Ảnh phụ
    $sql_anhphu = "SELECT * FROM anhphu WHERE id_sanpham = ? ORDER BY thutu_hien_thi ASC";
    $stmt2 = $mysqli->prepare($sql_anhphu);
    $stmt2->bind_param("i", $id_sanpham);
    $stmt2->execute();
    $result_anhphu = $stmt2->get_result();
    $stmt2->close();

    // Biến thể
    $sql_bienthe = "SELECT * FROM bienthesanpham WHERE id_sanpham = ?";
    $stmt3 = $mysqli->prepare($sql_bienthe);
    $stmt3->bind_param("i", $id_sanpham);
    $stmt3->execute();
    $result_bienthe = $stmt3->get_result();
    $stmt3->close();

    // Bình luận
    $sql_binhluan = "SELECT b.*, k.ten_khach FROM binhluan b 
                     JOIN khachhang k ON b.id_khach = k.id_khach 
                     WHERE b.id_sanpham = ? ORDER BY b.ngaybinhluan DESC";
    $stmt4 = $mysqli->prepare($sql_binhluan);
    $stmt4->bind_param("i", $id_sanpham);
    $stmt4->execute();
    $result_binhluan = $stmt4->get_result();
    $stmt4->close();
} else {
    echo "<p>Sản phẩm không tồn tại.</p>";
    exit;
}
?>

<div class="product-detail">
    <div class="product-images">
        <div class="main-image">
            <img id="mainImage" src="admin/modules/quanlysp/uploads/<?php echo $row_sanpham['hinhanh']; ?>" alt="Ảnh sản phẩm" width="400">
        </div>
        <div class="thumbnail-images">
            <?php while ($row_anhphu = $result_anhphu->fetch_assoc()) { ?>
                <img src="admin/modules/quanlysp/<?php echo $row_anhphu['duong_dan']; ?>"
                     class="thumbnail" width="80"
                     onmouseover="previewImage(this.src)"
                     onmouseout="resetImage()">
            <?php } ?>
        </div>
    </div>

    <div class="product-info">
        <h2><?php echo $row_sanpham['tensanpham']; ?></h2>
        <p><strong>Giá:</strong> <?php echo number_format($row_sanpham['giasp'], 0, ',', '.'); ?>đ</p>
        <p><strong>Tình trạng:</strong> <?php echo ($row_sanpham['tinhtrang'] == 1) ? "Còn hàng" : "Hết hàng"; ?></p>
        <p><strong>Tóm tắt:</strong> <?php echo $row_sanpham['tomtat']; ?></p>

        <form method="POST" action="page/main/themgiohang.php">
            <input type="hidden" name="id_sanpham" value="<?php echo $row_sanpham['id_sanpham']; ?>">
            <input type="hidden" name="tensanpham" value="<?php echo $row_sanpham['tensanpham']; ?>">
            <input type="hidden" name="giasp" value="<?php echo $row_sanpham['giasp']; ?>">
            <input type="hidden" name="hinhanh" value="<?php echo $row_sanpham['hinhanh']; ?>">

            <div class="product-variants">
                <p><strong>Chọn kích cỡ:</strong></p>
                <?php
                $kichco_ghep = [];
                $bienthe_data = [];
                while ($row_bt = $result_bienthe->fetch_assoc()) {
                    $kichcos = explode(',', trim($row_bt['kichco']));
                    foreach ($kichcos as $kc) {
                        $kc = trim($kc);
                        if (!empty($kc)) {
                            $kichco_ghep[] = $kc;
                            $bienthe_data[$kc][] = [
                                'mausac' => $row_bt['mausac'],
                                'id_bienthe' => $row_bt['id_bienthe']
                            ];
                        }
                    }
                }
                $kichco_ghep = array_unique($kichco_ghep);
                sort($kichco_ghep, SORT_NUMERIC);
                foreach ($kichco_ghep as $kc) {
                    echo "<label><input type='radio' name='kichco' value='$kc' required> $kc </label> ";
                }
                ?>

                <p><strong>Chọn màu sắc:</strong></p>
                <?php
                $ds_mausac = [];
                mysqli_data_seek($result_bienthe, 0);
                while ($row_bt2 = $result_bienthe->fetch_assoc()) {
                    $mausac = $row_bt2['mausac'];
                    if (!in_array($mausac, $ds_mausac)) {
                        $ds_mausac[] = $mausac;
                        $anh_mau = $row_bt2['hinhanh'] ?? 'noimage.png';
                        echo "<label><input type='radio' name='mausac' value='$mausac' required> 
                                <img src='admin/modules/quanlybienthe/bientheuploads/$anh_mau' width='50'> $mausac</label> ";
                    }
                }
                ?>
            </div>

            <label for="soluong"><strong>Số lượng:</strong></label><br>
            <input type="number" name="soluong" value="1" min="1" required><br><br>

            <button class="add-to-cart" type="submit" name="themgiohang">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>

<div class="product-description">
    <h3>Chi tiết sản phẩm</h3>
    <p><?php echo nl2br($row_sanpham['noidung']); ?></p>
</div>

<div class="product-comments">
    <?php if (!isset($_SESSION['dangkyk'])): ?>
        <p class="comment-login-notice">Bạn cần <a href="page/main/dangnhapkhach.php">đăng nhập</a> để bình luận.</p>
    <?php else: ?>
        <form method="POST" action="page/main/binhluan.php">
            <input type="hidden" name="id_sanpham_test" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <textarea class="content" name="content" placeholder="Mời bạn chia sẻ cảm nhận"></textarea>
            <input type="submit" name="thembinhluan" value="Gửi bình luận">
        </form>
    <?php endif; ?>
    <h3>Bình luận</h3>
    <?php
    $sql_lietke_content = "SELECT ten_khach, binhluan.id_khach, sanpham.id_sanpham, binhluan.noidung, ngaybinhluan 
                           FROM binhluan 
                           JOIN khachhang ON binhluan.id_khach = khachhang.id_khach 
                           JOIN sanpham ON sanpham.id_sanpham = binhluan.id_sanpham 
                           WHERE sanpham.id_sanpham = ?";
    $stmt = $mysqli->prepare($sql_lietke_content);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class="product-rating">
            <strong><?php echo htmlspecialchars($row['ten_khach']); ?></strong> - <em><?php echo htmlspecialchars($row['ngaybinhluan']); ?></em>
            <p><?php echo htmlspecialchars($row['noidung']); ?></p>
        </div>
    <?php
    }
    $stmt->close();
    ?>
</div>

<style>
    .product-detail {
        display: flex;
        gap: 40px;
        margin: 20px;
    }

    .product-images {
        flex: 1;
    }

    .main-image img {
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .thumbnail-images {
        margin-top: 10px;
    }

    .thumbnail {
        margin-right: 8px;
        cursor: pointer;
        border: 1px solid #ddd;
        padding: 2px;
    }

    .product-info {
        flex: 1;
    }

    .product-info input[type="radio"] {
        margin-right: 5px;
    }

    .product-description,
    .product-comments {
        margin: 20px;
    }

    .add-to-cart {
        margin-top: 10px;
        padding: 8px 20px;
        background-color: black;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>

<!-- Script xử lý hover ảnh phụ -->
<script>
    const mainImage = document.getElementById('mainImage');
    const originalSrc = mainImage.src;

    function previewImage(src) {
        mainImage.src = src;
    }

    function resetImage() {
        mainImage.src = originalSrc;
    }
</script>
