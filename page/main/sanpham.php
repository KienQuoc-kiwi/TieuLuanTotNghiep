<?php
$sql_chitiet = "SELECT * FROM sanpham, danhmuc 
                WHERE sanpham.id_danhmuc = danhmuc.id_danhmuc 
                AND sanpham.id_sanpham = '$_GET[id]' 
                LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
$row_chitiet = mysqli_fetch_array($query_chitiet);
?>

<div class="product-detail-container">
    <!-- Left - Image -->
    <div class="product-image-section">
        <img src="admin/modules/quanlysp/uploads/<?php echo $row_chitiet['hinhanh']?>" alt="Hình lỗi">
    </div>

    <!-- Right - Info & Options -->
    <div class="product-info-section">
        <h2 class="product-name"><?php echo $row_chitiet['tensanpham']?></h2>
        <p class="product-code">Mã sản phẩm: <?php echo $row_chitiet['masp']?></p>
        <p class="product-price">Giá: <?php echo number_format($row_chitiet['giasp'], 0, ',', '.') ?> ₫</p>
        <p class="product-category">Danh mục: <?php echo $row_chitiet['tendanhmuc']?></p>

        <!-- Form chọn biến thể -->
        <form method="POST" action="page/main/themgiohang.php" id="addToCartForm">
            <input type="hidden" name="id_sanpham" value="<?php echo $row_chitiet['id_sanpham'] ?>">
            <input type="hidden" name="id_bienthe" id="selectedVariant" required>

            <!-- Chọn màu sắc -->
            <div class="color-options">
                <label>Màu sắc:</label>
                <div class="color-thumbnails">
                    <?php
                    $sql_mausac = "SELECT DISTINCT mausac, hinhanh FROM bienthesanpham 
                                   WHERE id_sanpham = '{$row_chitiet['id_sanpham']}'";
                    $query_mausac = mysqli_query($mysqli, $sql_mausac);
                    while($color = mysqli_fetch_array($query_mausac)) {
                        echo '
                            <img class="color-option" src="admin/modules/quanlybienthe/uploads/'.$color['hinhanh'].'" 
                                 data-color="'.$color['mausac'].'" alt="'.$color['mausac'].'">
                        ';
                    }
                    ?>
                </div>
            </div>

            <!-- Kích cỡ -->
            <div class="size-options">
                <label>Kích cỡ:</label>
                <div class="size-grid" id="sizeGrid">
                    <!-- Các nút kích cỡ sẽ được render từ JavaScript -->
                </div>
            </div>

            <input type="submit" class="add-to-cart-btn" name="themgiohang" value="Thêm vào giỏ hàng">
        </form>

        <button class="favourite-btn">❤ Yêu thích</button>
    </div>
</div>

<!-- Bình luận -->
<div class="product-comment-section">
    <form method="POST" action="page/main/binhluan.php">
        <input type="hidden" name="id_sanpham_test" value="<?php echo $_GET['id']; ?>">
        <textarea class="content" name="content" placeholder="Mời bạn chia sẻ cảm nhận"></textarea>
        <input type="submit" name="thembinhluan" value="Gửi bình luận">
    </form>

    <h3>Bình luận:</h3>
    <?php
    $sql_lietke_content = "SELECT ten_khach, binhluan.id_khach, sanpham.id_sanpham, binhluan.noidung, ngaybinhluan 
                           FROM binhluan, khachhang, sanpham 
                           WHERE binhluan.id_khach = khachhang.id_khach 
                             AND sanpham.id_sanpham = binhluan.id_sanpham 
                             AND sanpham.id_sanpham = '$_GET[id]'";
    $query_lietke_content = mysqli_query($mysqli,$sql_lietke_content);
    while($row = mysqli_fetch_array($query_lietke_content)) {
    ?>
        <div class="product-rating">
            <strong><?php echo $row['ten_khach']?></strong> - <em><?php echo $row['ngaybinhluan']?></em>
            <p><?php echo $row['noidung'] ?></p>
        </div>
    <?php } ?>
</div>

<!-- JavaScript xử lý chọn màu và size -->
<script>
    const colorOptions = document.querySelectorAll('.color-option');
    const sizeGrid = document.getElementById('sizeGrid');
    let selectedColor = '';

    colorOptions.forEach(option => {
        option.addEventListener('click', () => {
            selectedColor = option.dataset.color;

            // Highlight ảnh màu đang chọn
            document.querySelectorAll('.color-option').forEach(img => img.classList.remove('selected'));
            option.classList.add('selected');

            // Gửi Ajax để lấy size theo màu
            fetch(`page/main/bienthe.php?id_sanpham=<?php echo $_GET['id']; ?>&color=${encodeURIComponent(selectedColor)}`)
                .then(res => res.json())
                .then(data => {
                    console.log("Dữ liệu size:", data); // Debug

                    sizeGrid.innerHTML = '';
                    data.forEach(item => {
                        const btn = document.createElement('button');
                        btn.textContent = item.kichco;
                        btn.className = 'size-button';
                        btn.dataset.id_bienthe = item.id_bienthe;

                        btn.addEventListener('click', (e) => {
                            e.preventDefault();
                            document.getElementById('selectedVariant').value = item.id_bienthe;

                            // Highlight size đã chọn
                            document.querySelectorAll('.size-button').forEach(b => b.classList.remove('selected'));
                            btn.classList.add('selected');
                        });

                        sizeGrid.appendChild(btn);
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi load kích cỡ:', error);
                });
        });
    });
</script>

<!-- CSS -->
<style>
    .color-thumbnails img {
        width: 60px;
        height: 60px;
        margin: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 4px;
    }
    .color-thumbnails img.selected {
        border: 2px solid black;
    }

    .size-button {
        padding: 10px 15px;
        margin: 5px;
        border: 1px solid #ccc;
        background: #f0f0f0;
        cursor: pointer;
        border-radius: 5px;
    }

    .size-button.selected {
        background-color: black;
        color: white;
    }
</style>
