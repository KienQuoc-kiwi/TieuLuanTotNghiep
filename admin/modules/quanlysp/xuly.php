<?php
ob_start();
include('../../../config/config.php');

// Hàm upload ảnh đơn giản
function uploadImage($file, $targetDir) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    if ($file['error'] == UPLOAD_ERR_OK) {
        $filename = time() . '_' . basename($file['name']);
        $targetFile = $targetDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $filename;
        }
    }
    return ''; // Trả về rỗng nếu upload thất bại
}

// ================== THÊM SẢN PHẨM ==================
if (isset($_POST['themsp'])) {
    $tensanpham = trim($_POST['tensanpham'] ?? '');
    $masp = trim($_POST['masp'] ?? '');
    $giasp = (int)($_POST['giasp'] ?? 0);
    $soluong = (int)($_POST['soluong'] ?? 0);
    $hinhanh = ($_FILES['hinhanh']['name'] ?? '') != '' ? uploadImage($_FILES['hinhanh'], 'uploads/') : '';
    $tomtat = trim($_POST['tomtat'] ?? '');
    $tinhtrang = (int)($_POST['tinhtrang'] ?? 0);
    $danhmuc = (int)($_POST['danhmuc'] ?? 0);
    $danhmuccon = isset($_POST['danhmuccon']) && $_POST['danhmuccon'] != '' ? (int)$_POST['danhmuccon'] : null;
    $noidung = trim($_POST['noidung'] ?? '');

    if (empty($tensanpham) || empty($masp)) {
        echo "Tên sản phẩm và mã sản phẩm là bắt buộc.";
        exit;
    }

    $sql_them = "INSERT INTO sanpham (tensanpham, masp, giasp, soluong, hinhanh, tomtat, noidung, tinhtrang, id_danhmuc, id_danhmuccon) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $sql_them);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssiisssiii", $tensanpham, $masp, $giasp, $soluong, $hinhanh, $tomtat, $noidung, $tinhtrang, $danhmuc, $danhmuccon);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../../indexad.php?action=quanlysanpham&query=lietke');
            exit;
        } else {
            echo "Lỗi khi thêm sản phẩm: " . mysqli_error($mysqli);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi chuẩn bị truy vấn: " . mysqli_error($mysqli);
    }
    exit;
}

// ================== SỬA SẢN PHẨM ==================
elseif (isset($_POST['suasanpham'])) {
    $id_sanpham = (int)($_GET['id_sanpham'] ?? 0);
    if ($id_sanpham <= 0) {
        echo "ID sản phẩm không hợp lệ.";
        exit;
    }

    $tensanpham = trim($_POST['tensanpham'] ?? '');
    $masp = trim($_POST['masp'] ?? '');
    $giasp = (int)($_POST['giasp'] ?? 0);
    $soluong = (int)($_POST['soluong'] ?? 0);
    $hinhanh = ($_FILES['hinhanh']['name'] ?? '') != '' ? uploadImage($_FILES['hinhanh'], 'uploads/') : '';
    $tomtat = trim($_POST['tomtat'] ?? '');
    $tinhtrang = (int)($_POST['tinhtrang'] ?? 0);
    $danhmuc = (int)($_POST['danhmuc'] ?? 0);
    $danhmuccon = isset($_POST['danhmuccon']) && $_POST['danhmuccon'] != '' ? (int)$_POST['danhmuccon'] : null;
    $noidung = trim($_POST['noidung'] ?? '');

    $sql_old = "SELECT hinhanh FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt_old = mysqli_prepare($mysqli, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "i", $id_sanpham);
    mysqli_stmt_execute($stmt_old);
    $result_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($result_old);

    if ($hinhanh != '') {
        if (!empty($row_old['hinhanh']) && file_exists('uploads/' . $row_old['hinhanh'])) {
            unlink('uploads/' . $row_old['hinhanh']);
        }
        $sql_update = "UPDATE sanpham SET tensanpham=?, masp=?, giasp=?, soluong=?, hinhanh=?, tomtat=?, noidung=?, tinhtrang=?, id_danhmuc=?, id_danhmuccon=? WHERE id_sanpham=?";
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssiissssiii", $tensanpham, $masp, $giasp, $soluong, $hinhanh, $tomtat, $noidung, $tinhtrang, $danhmuc, $danhmuccon, $id_sanpham);
    } else {
        $sql_update = "UPDATE sanpham SET tensanpham=?, masp=?, giasp=?, soluong=?, tomtat=?, noidung=?, tinhtrang=?, id_danhmuc=?, id_danhmuccon=? WHERE id_sanpham=?";
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssiissssii", $tensanpham, $masp, $giasp, $soluong, $tomtat, $noidung, $tinhtrang, $danhmuc, $danhmuccon, $id_sanpham);
    }

    if ($stmt && mysqli_stmt_execute($stmt)) {
        header('Location: ../../indexad.php?action=quanlysanpham&query=lietke');
    } else {
        echo "Lỗi khi cập nhật sản phẩm: " . mysqli_error($mysqli);
    }
    if ($stmt) mysqli_stmt_close($stmt);
    exit;
}

// ================== XOÁ SẢN PHẨM ==================
elseif (isset($_GET['query']) && $_GET['query'] == 'xoa') {
    $id_sanpham = (int)($_GET['id_sanpham'] ?? 0);
    if ($id_sanpham <= 0) {
        echo "ID sản phẩm không hợp lệ.";
        exit;
    }

    $sql = "SELECT hinhanh FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($row && !empty($row['hinhanh']) && file_exists('uploads/' . $row['hinhanh'])) {
        unlink('uploads/' . $row['hinhanh']);
    }

    $sql_xoa = "DELETE FROM sanpham WHERE id_sanpham = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../indexad.php?action=quanlysanpham&query=lietke');
    } else {
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($mysqli);
    }
    mysqli_stmt_close($stmt);
    exit;
}

ob_end_flush();
?>
