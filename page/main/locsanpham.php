<?php
require '../../config/config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id_danhmuc = (int)$data['id_danhmuc'];
$id_danhmuccon = (int)$data['id_danhmuccon'];
$subcategories = $data['subcategories'] ?? [];
$colors = $data['colors'] ?? [];
$sizes = $data['sizes'] ?? [];
$prices = $data['prices'] ?? [];
$sort = $data['sort'] ?? 'newest';

$sql = "SELECT sp.*, dm.tendanhmuc FROM sanpham sp JOIN danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc";
$conditions = ["sp.id_danhmuc = ?"];
$params = [$id_danhmuc];
$types = 'i';

if ($id_danhmuccon) {
    $conditions[] = "sp.id_danhmuc IN (SELECT id_danhmuc FROM danhmuccon WHERE id_danhmuccon = ?)";
    $params[] = $id_danhmuccon;
    $types .= 'i';
}

if (!empty($subcategories)) {
    $placeholders = implode(',', array_fill(0, count($subcategories), '?'));
    $conditions[] = "sp.id_danhmuc IN (SELECT id_danhmuc FROM danhmuccon WHERE id_danhmuccon IN ($placeholders))";
    $params = array_merge($params, $subcategories);
    $types .= str_repeat('i', count($subcategories));
}

if (!empty($colors)) {
    $placeholders = implode(',', array_fill(0, count($colors), '?'));
    $conditions[] = "sp.id_sanpham IN (SELECT id_sanpham FROM bienthesanpham WHERE mausac IN ($placeholders))";
    $params = array_merge($params, $colors);
    $types .= str_repeat('s', count($colors));
}

if (!empty($sizes)) {
    $placeholders = implode(',', array_fill(0, count($sizes), '?'));
    $conditions[] = "sp.id_sanpham IN (SELECT id_sanpham FROM bienthesanpham WHERE kichco IN ($placeholders))";
    $params = array_merge($params, $sizes);
    $types .= str_repeat('s', count($sizes));
}

if (!empty($prices)) {
    $price_conditions = [];
    foreach ($prices as $price) {
        if ($price === '0-500000') {
            $price_conditions[] = "sp.giasp BETWEEN 0 AND 500000";
        } elseif ($price === '500000-1000000') {
            $price_conditions[] = "sp.giasp BETWEEN 500000 AND 1000000";
        } elseif ($price === '1000000-2000000') {
            $price_conditions[] = "sp.giasp BETWEEN 1000000 AND 2000000";
        } elseif ($price === '2000000-') {
            $price_conditions[] = "sp.giasp > 2000000";
        }
    }
    $conditions[] = "(" . implode(' OR ', $price_conditions) . ")";
}

$sql .= " WHERE " . implode(' AND ', $conditions);
if ($sort === 'price-asc') {
    $sql .= " ORDER BY sp.giasp ASC";
} elseif ($sort === 'price-desc') {
    $sql .= " ORDER BY sp.giasp DESC";
} else {
    $sql .= " ORDER BY sp.id_sanpham DESC";
}
$sql .= " LIMIT 12";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($products);
?>