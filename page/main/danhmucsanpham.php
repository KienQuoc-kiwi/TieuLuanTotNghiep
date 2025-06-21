<?php
require 'config/config.php';
$id_danhmuc = isset($_GET['id_danhmuc']) ? (int)$_GET['id_danhmuc'] : 0;
$id_danhmuccon = isset($_GET['id_danhmuccon']) ? (int)$_GET['id_danhmuccon'] : 0;

// Lấy tên danh mục
$sql_danhmuc = "SELECT tendanhmuc FROM danhmuc WHERE id_danhmuc = ?";
$stmt_danhmuc = mysqli_prepare($mysqli, $sql_danhmuc);
mysqli_stmt_bind_param($stmt_danhmuc, 'i', $id_danhmuc);
mysqli_stmt_execute($stmt_danhmuc);
$result_danhmuc = mysqli_stmt_get_result($stmt_danhmuc);
$danhmuc = mysqli_fetch_assoc($result_danhmuc)['tendanhmuc'] ?? 'Danh mục';

// Lấy tên danh mục con và mô tả cho SEO
$ten_danhmuccon = '';
$meta_description = '';
if ($id_danhmuccon) {
    $sql_danhmuccon = "SELECT ten_danhmuccon, mota FROM danhmuccon WHERE id_danhmuccon = ?";
    $stmt_danhmuccon = mysqli_prepare($mysqli, $sql_danhmuccon);
    mysqli_stmt_bind_param($stmt_danhmuccon, 'i', $id_danhmuccon);
    mysqli_stmt_execute($stmt_danhmuccon);
    $result_danhmuccon = mysqli_stmt_get_result($stmt_danhmuccon);
    $danhmuccon = mysqli_fetch_assoc($result_danhmuccon);
    $ten_danhmuccon = $danhmuccon['ten_danhmuccon'] ?? '';
    $meta_description = $danhmuccon['mota'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <title><?php echo htmlspecialchars($ten_danhmuccon ? "$ten_danhmuccon - $danhmuc" : $danhmuc); ?> - Cửa hàng giày</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/danhmucsanpham.css">
</head>
<body>
    
    <div class="adidas-category-page">
        <!-- <aside class="adidas-sidebar">
            <button class="adidas-filter-toggle" onclick="toggleFilter()">Bộ lọc</button>
            <div class="adidas-filter-modal" id="filter-modal">
                <h3 class="adidas-filter-title">Bộ lọc</h3>
                <div class="adidas-filter-group">
                    <h4 class="adidas-filter-heading">Danh mục con</h4>
                    <?php
                    $sql_sub = "SELECT * FROM danhmuccon WHERE id_danhmuc = ?";
                    $stmt_sub = mysqli_prepare($mysqli, $sql_sub);
                    mysqli_stmt_bind_param($stmt_sub, 'i', $id_danhmuc);
                    mysqli_stmt_execute($stmt_sub);
                    $result_sub = mysqli_stmt_get_result($stmt_sub);
                    while ($row_sub = mysqli_fetch_assoc($result_sub)) {
                        echo '<label><input type="checkbox" name="subcategory" value="' . $row_sub['id_danhmuccon'] . '" onchange="filterProducts()">' . htmlspecialchars($row_sub['ten_danhmuccon']) . '</label><br>';
                    }
                    ?>
                </div>
                <div class="adidas-filter-group">
                    <h4 class="adidas-filter-heading">Màu sắc</h4>
                    <?php
                    $sql_colors = "SELECT DISTINCT mausac FROM bienthesanpham WHERE id_sanpham IN (SELECT id_sanpham FROM sanpham WHERE id_danhmuc = ?)";
                    $stmt_colors = mysqli_prepare($mysqli, $sql_colors);
                    mysqli_stmt_bind_param($stmt_colors, 'i', $id_danhmuc);
                    mysqli_stmt_execute($stmt_colors);
                    $result_colors = mysqli_stmt_get_result($stmt_colors);
                    while ($row_color = mysqli_fetch_assoc($result_colors)) {
                        echo '<label><input type="checkbox" name="color" value="' . htmlspecialchars($row_color['mausac']) . '" onchange="filterProducts()">' . htmlspecialchars($row_color['mausac']) . '</label><br>';
                    }
                    ?>
                </div>
                <div class="adidas-filter-group">
                    <h4 class="adidas-filter-heading">Kích cỡ</h4>
                    <?php
                    $sql_sizes = "SELECT DISTINCT kichco FROM bienthesanpham WHERE id_sanpham IN (SELECT id_sanpham FROM sanpham WHERE id_danhmuc = ?)";
                    $stmt_sizes = mysqli_prepare($mysqli, $sql_sizes);
                    mysqli_stmt_bind_param($stmt_sizes, 'i', $id_danhmuc);
                    mysqli_stmt_execute($stmt_sizes);
                    $result_sizes = mysqli_stmt_get_result($stmt_sizes);
                    while ($row_size = mysqli_fetch_assoc($result_sizes)) {
                        echo '<label><input type="checkbox" name="size" value="' . htmlspecialchars($row_size['kichco']) . '" onchange="filterProducts()">' . htmlspecialchars($row_size['kichco']) . '</label><br>';
                    }
                    ?>
                </div>
                <div class="adidas-filter-group">
                    <h4 class="adidas-filter-heading">Giá</h4>
                    <label><input type="checkbox" name="price" value="0-500000" onchange="filterProducts()">Dưới 500,000₫</label><br>
                    <label><input type="checkbox" name="price" value="500000-1000000" onchange="filterProducts()">500,000₫ - 1,000,000₫</label><br>
                    <label><input type="checkbox" name="price" value="1000000-2000000" onchange="filterProducts()">1,000,000₫ - 2,000,000₫</label><br>
                    <label><input type="checkbox" name="price" value="2000000-" onchange="filterProducts()">Trên 2,000,000₫</label><br>
                </div>
            </div>
        </aside> -->
        <main class="adidas-product-list">
            <div class="adidas-sort-bar">
                <select id="sort" onchange="filterProducts()">
                    <option value="newest">Mới nhất</option>
                    <option value="price-asc">Giá: Thấp đến cao</option>
                    <option value="price-desc">Giá: Cao đến thấp</option>
                </select>
            </div>
            <div class="adidas-section-content">
                <h2 class="adidas-category-title"><?php echo htmlspecialchars($ten_danhmuccon ? $ten_danhmuccon : $danhmuc); ?></h2>
                <div class="adidas-row-edit">
                    <div class="adidas-pro-loop">
                        <div class="adidas-horizontal-scroll-container" id="product-list">
                            <?php
                            $sql_pro = "SELECT sp.*, dm.tendanhmuc FROM sanpham sp JOIN danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc WHERE sp.id_danhmuc = ? AND (sp.id_danhmuccon = ? OR ? IS NULL)";
                            $params = [$id_danhmuc, $id_danhmuccon, $id_danhmuccon];
                            $types = 'iii';
                            $sql_pro .= " ORDER BY sp.id_sanpham DESC LIMIT 12";
                            $stmt_pro = mysqli_prepare($mysqli, $sql_pro);
                            mysqli_stmt_bind_param($stmt_pro, $types, ...$params);
                            mysqli_stmt_execute($stmt_pro);
                            $result_pro = mysqli_stmt_get_result($stmt_pro);
                            while ($row = mysqli_fetch_assoc($result_pro)) {
                            ?>
                                <div class="adidas-product-card">
                                    <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham']; ?>">
                                        <img src="admin/modules/quanlysp/uploads/<?php echo htmlspecialchars($row['hinhanh']); ?>" alt="<?php echo htmlspecialchars($row['tensanpham']); ?>">
                                        <p class="adidas-title-product"><?php echo htmlspecialchars($row['tensanpham']); ?></p>
                                        <p class="adidas-price-product"><?php echo number_format($row['giasp'], 0, ',', '.') . '₫'; ?></p>
                                        <p class="adidas-category-label"><?php echo htmlspecialchars($row['tendanhmuc']); ?></p>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>

<script>
function toggleFilter() {
    const modal = document.getElementById('filter-modal');
    modal.classList.toggle('active');
}

function filterProducts() {
    const subcategories = Array.from(document.querySelectorAll('input[name="subcategory"]:checked')).map(el => el.value);
    const colors = Array.from(document.querySelectorAll('input[name="color"]:checked')).map(el => el.value);
    const sizes = Array.from(document.querySelectorAll('input[name="size"]:checked')).map(el => el.value);
    const prices = Array.from(document.querySelectorAll('input[name="price"]:checked')).map(el => el.value);
    const sort = document.getElementById('sort').value;

    fetch('locsanpham.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_danhmuc: <?php echo $id_danhmuc; ?>,
            id_danhmuccon: <?php echo $id_danhmuccon; ?>,
            subcategories: subcategories,
            colors: colors,
            sizes: sizes,
            prices: prices,
            sort: sort
        })
    })
    .then(response => response.json())
    .then(data => {
        const productList = document.getElementById('product-list');
        productList.innerHTML = data.map(product => `
            <div class="adidas-product-card">
                <a href="index.php?quanly=sanpham&id=${product.id_sanpham}">
                    <img src="admin/modules/quanlysp/uploads/${product.hinhanh}" alt="${product.tensanpham}">
                    <p class="adidas-title-product">${product.tensanpham}</p>
                    <p class="adidas-price-product">${new Intl.NumberFormat('vi-VN').format(product.giasp)}₫</p>
                    <p class="adidas-category-label">${product.tendanhmuc}</p>
                </a>
            </div>
        `).join('');
    });
}
</script>