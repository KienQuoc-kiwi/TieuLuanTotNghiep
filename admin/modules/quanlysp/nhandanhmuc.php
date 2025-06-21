<?php
require '../../../config/config.php';
header('Content-Type: application/json');

$id_danhmuc = isset($_POST['id_danhmuc']) ? (int)$_POST['id_danhmuc'] : 0;
$subcategories = [];

if ($id_danhmuc > 0) {
    $sql = "SELECT id_danhmuccon, ten_danhmuccon FROM danhmuccon WHERE id_danhmuc = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id_danhmuc);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $subcategories[] = [
                'id_danhmuccon' => $row['id_danhmuccon'],
                'ten_danhmuccon' => $row['ten_danhmuccon']
            ];
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Prepare statement failed: " . mysqli_error($mysqli));
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }
}

echo json_encode($subcategories);
?>