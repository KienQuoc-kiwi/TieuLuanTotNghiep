<p>Chi tiết sản phẩm</p>
<link rel="stylesheet" href="admin/css/chitietsanpham.css">
<?php
$sql_chitiet = "SELECT * FROM sanpham, danhmuc WHERE sanpham.id_danhmuc = danhmuc.id_danhmuc AND sanpham.id_sanpham = '$_GET[id]' LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
while($row_chitiet = mysqli_fetch_array($query_chitiet)) {
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

        <!-- Select size -->
        <div class="product-size-options">
            <label>Chọn size:</label>
            <select name="size">
                <option>EU 40</option>
                <option>EU 41</option>
                <option>EU 42</option>
                <option>EU 43</option>
            </select>
        </div>

        <form method="POST" action="page/main/themgiohang.php?id_sanpham=<?php echo $row_chitiet['id_sanpham']?>">
            <input type="submit" class="add-to-cart-btn" name="themgiohang" value="Thêm vào giỏ hàng">
        </form>

        <button class="favourite-btn">❤ Yêu thích</button>
    </div>
</div>

<!-- Bình luận -->
<div class="product-comment-section">
    <form method="POST" action="main/comment/xulycontent.php">
        <input type="hidden" name="id_sanpham_test" value="<?php echo $_GET['id']; ?>">
        <textarea class="content" name="content" placeholder="Mời bạn chia sẻ cảm nhận"></textarea>
        <input type="submit" name="thembinhluan" value="Gửi bình luận">
        <link rel="stylesheet" href="../admin/css/sanpham.css">
    </form>

    <h3>Bình luận:</h3>
    <?php
    $sql_lietke_content = "SELECT tenkhachhang, binhluan.id_khachhang, sanpham.id_sanpham, binhluan.noidung, ngaybinhluan FROM binhluan, dangkykhach, sanpham WHERE binhluan.id_khachhang = dangkykhach.id_dkkhach AND sanpham.id_sanpham = binhluan.id_sanpham AND sanpham.id_sanpham = '$_GET[id]'";
    $query_lietke_content = mysqli_query($mysqli,$sql_lietke_content);
    while($row = mysqli_fetch_array($query_lietke_content)) {
    ?>
        <div class="product-rating">
            <strong><?php echo $row['tenkhachhang']?></strong> - <em><?php echo $row['ngaybinhluan']?></em>
            <p><?php echo $row['noidung'] ?></p>
        </div>
    <?php } ?>
</div>
<?php } ?>
