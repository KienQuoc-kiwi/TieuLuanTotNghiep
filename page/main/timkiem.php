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

<h3 class="tu-khoa-tim-kiem">Từ khóa tìm kiếm: <?php echo htmlspecialchars($tukhoa); ?></h3>
<div class="khung-tim-kiem-adidas">
<ul class="danh-sach-san-pham">
    <?php while ($row = mysqli_fetch_array($query_pro)) { ?>
        <li class="san-pham">
            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>" style="text-decoration: none;">
                <img src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh']; ?>" alt="Hình lỗi" width="100" height="100">
                <p class="ten-san-pham"><?php echo $row['tensanpham']; ?></p>
                <p class="gia-san-pham"><?php echo number_format($row['giasp'], 0, ',', '.') . ' vnđ'; ?></p>
                <p class="danh-muc"><?php echo $row['tendanhmuc']; ?></p>
            </a>
        </li>
    <?php } ?>
</ul>
</div>