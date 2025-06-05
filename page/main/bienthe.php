<?php
include('../../config/config.php');

$id_sanpham = $_GET['id_sanpham'];
$color = $_GET['color'];

$sql = "SELECT id_bienthe, kichco FROM bienthesanpham 
        WHERE id_sanpham = '$id_sanpham' AND mausac = '$color'";
$query = mysqli_query($mysqli, $sql);

$data = [];
while($row = mysqli_fetch_array($query)) {
    $data[] = [
        'id_bienthe' => $row['id_bienthe'],
        'kichco' => $row['kichco']
    ];
}

echo json_encode($data);
?>
