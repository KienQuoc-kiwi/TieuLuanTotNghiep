<?php
include('../../../config/config.php');

function uploadImage($file, $targetDir) {
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $filename = time() . '_' . basename($file['name']);
    $filepath = $targetDir . $filename;
    if (move_uploaded_file($file['tmp_name'], $filepath)) return $filename;
    return false;
}

// ======= THÊM ==========
if (isset($_POST['them_bienthe'])) {
    $id_sanpham = $_POST['id_sanpham'];
    foreach ($_POST['kichco'] as $i => $kichco) {
        $mausac = $_POST['mausac'][$i];
        $soluongtonkho = $_POST['soluongtonkho'][$i];
        $madinhdanh = $_POST['madinhdanh'][$i];

        $hinhanhFile = $_FILES['hinhanh']['tmp_name'][$i];
        $hinhanhName = $_FILES['hinhanh']['name'][$i];

        $hinhanh = uploadImage([
            'name' => $hinhanhName,
            'tmp_name' => $hinhanhFile
        ], 'bientheuploads/');

        if ($hinhanh) {
            $sql = "INSERT INTO bienthesanpham (id_sanpham, kichco, mausac, soluongtonkho, madinhdanh, hinhanh) 
                    VALUES ('$id_sanpham', '$kichco', '$mausac', '$soluongtonkho', '$madinhdanh', '$hinhanh')";
            mysqli_query($mysqli, $sql);
        }
    }
    header("Location: ../../indexad.php?action=quanlybienthe&query=lietke&idsp=$id_sanpham");
    exit;
}

// ======= XÓA ==========
if (isset($_GET['query']) && $_GET['query'] == 'xoa') {
    $id = $_GET['id_bienthe'];
    $idsp = $_GET['id_sanpham'];

    $qr = mysqli_query($mysqli, "SELECT hinhanh FROM bienthesanpham WHERE id_bienthe = $id");
    $row = mysqli_fetch_assoc($qr);
    if (!empty($row['hinhanh']) && file_exists('bientheuploads/' . $row['hinhanh'])) {
        unlink('bientheuploads/' . $row['hinhanh']);
    }

    mysqli_query($mysqli, "DELETE FROM bienthesanpham WHERE id_bienthe = $id");
    header("Location: ../../indexad.php?action=quanlybienthe&query=lietke&idsp=$idsp");
    exit;
}

// ======= SỬA ==========
if (isset($_POST['sua_bienthe'])) {
    $id_bienthe = $_POST['id_bienthe'];
    $id_sanpham = $_POST['id_sanpham'];
    $kichco = $_POST['kichco'];
    $mausac = $_POST['mausac'];
    $soluongtonkho = $_POST['soluongtonkho'];
    $madinhdanh = $_POST['madinhdanh'];

    if ($_FILES['hinhanh']['name'] != '') {
        $hinhanh = uploadImage($_FILES['hinhanh'], 'bientheuploads/');
        $old = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT hinhanh FROM bienthesanpham WHERE id_bienthe = $id_bienthe"));
        if (!empty($old['hinhanh']) && file_exists('bientheuploads/' . $old['hinhanh'])) {
            unlink('bientheuploads/' . $old['hinhanh']);
        }

        $sql = "UPDATE bienthesanpham SET kichco='$kichco', mausac='$mausac', soluongtonkho='$soluongtonkho', madinhdanh='$madinhdanh', hinhanh='$hinhanh' WHERE id_bienthe=$id_bienthe";
    } else {
        $sql = "UPDATE bienthesanpham SET kichco='$kichco', mausac='$mausac', soluongtonkho='$soluongtonkho', madinhdanh='$madinhdanh' WHERE id_bienthe=$id_bienthe";
    }

    mysqli_query($mysqli, $sql);
    header("Location: ../../indexad.php?action=quanlybienthe&query=lietke&idsp=$id_sanpham");
    exit;
}
