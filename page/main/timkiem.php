<?php
$tukhoa = '';
if (isset($_POST['timkiem'])) {
    $tukhoa = trim($_POST['tukhoa']); // loại bỏ khoảng trắng đầu/cuối
}

$sql_pro = "SELECT * FROM sanpham, danhmuc 
            WHERE sanpham.id_danhmuc = danhmuc.id_danhmuc 
              AND sanpham.tensanpham LIKE N'%$tukhoa%'"; // N'...' nếu dùng Tiếng Việt trong SQL Server

$query_pro = mysqli_query($mysqli, $sql_pro);
?>

<div class="container">
    <div class="banner"><img src="img/mainbanner.png" alt="Poster"> </div>
</div>

<h3>Từ khóa tìm kiếm: <?php echo htmlspecialchars($tukhoa); ?></h3>
<ul class="product_list">
    <?php while ($row = mysqli_fetch_array($query_pro)) { ?>
        <li>
            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                <img src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh']; ?>" alt="Hình lỗi">
                <p class="title_product">Tên sản phẩm: <?php echo $row['tensanpham']; ?></p>
                <p class="price_product">Giá: <?php echo number_format($row['giasp'], 0, ',', '.') . ' vnđ'; ?></p>
                <p style="text-align: center; color: green"><?php echo $row['tendanhmuc']; ?></p>
            </a>
        </li>
    <?php } ?>
</ul>