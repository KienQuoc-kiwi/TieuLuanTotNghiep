<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../../../config/config.php');

function uploadMultipleImages($files, $targetDir) {
    $absoluteDir = __DIR__ . '/' . $targetDir;
    if (!is_dir($absoluteDir)) {
        mkdir($absoluteDir, 0755, true) or error_log("Không thể tạo thư mục: " . $absoluteDir);
    }
    $uploaded = [];
    foreach ($files['name'] as $key => $name) {
        if ($files['error'][$key] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . uniqid() . '_' . basename($name);
            $filepath = $absoluteDir . '/' . $filename;
            if (move_uploaded_file($files['tmp_name'][$key], $filepath)) {
                $uploaded[] = $targetDir . $filename;
            } else {
                error_log("Upload failed for file: " . $name . " to " . $filepath);
            }
        } else {
            error_log("Upload error for file: " . $name . " - Error code: " . $files['error'][$key]);
        }
    }
    return $uploaded;
}

function uploadImage($file, $targetDir) {
    $absoluteDir = __DIR__ . '/' . $targetDir;
    if (!is_dir($absoluteDir)) {
        mkdir($absoluteDir, 0755, true) or error_log("Không thể tạo thư mục: " . $absoluteDir);
    }
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = time() . '_' . uniqid() . '_' . basename($file['name']);
        $filepath = $absoluteDir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $targetDir . $filename;
        } else {
            error_log("Upload failed for file: " . $file['name'] . " to " . $filepath);
        }
    }
    return false;
}

// ================== THÊM ẢNH PHỤ ==================
if (isset($_POST['them_anhphu'])) {
    $id_sanpham = (int)($_POST['id_sanpham'] ?? 0);
    $thutu_hien_thi = (int)($_POST['thutu_hien_thi'] ?? 0);
    $hinhanh_phu = $_FILES['hinhanh_phu'] ?? [];

    if ($id_sanpham <= 0) {
        $_SESSION['error'] = "ID sản phẩm không hợp lệ.";
        header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh');
        exit;
    }

    $sql_check = "SELECT id_sanpham FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt_check = mysqli_prepare($mysqli, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $id_sanpham);
    mysqli_stmt_execute($stmt_check);
    if (mysqli_stmt_get_result($stmt_check)->num_rows === 0) {
        $_SESSION['error'] = "Sản phẩm không tồn tại.";
        header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh');
        exit;
    }

    $duong_dan_list = uploadMultipleImages($hinhanh_phu, 'anhphuuploads/');
    if (!empty($duong_dan_list)) {
        $added = false;
        $sql_insert = "INSERT INTO anhphu (id_sanpham, duong_dan, thutu_hien_thi) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($mysqli, $sql_insert);
        if ($stmt_insert === false) {
            error_log("Lỗi prepare insert: " . mysqli_error($mysqli));
            $_SESSION['error'] = "Lỗi chuẩn bị thêm ảnh phụ.";
            header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh');
            exit;
        }

        foreach ($duong_dan_list as $duong_dan) {
            mysqli_stmt_bind_param($stmt_insert, "isi", $id_sanpham, $duong_dan, $thutu_hien_thi);
            if (mysqli_stmt_execute($stmt_insert)) {
                $added = true;
            } else {
                error_log("Lỗi thêm ảnh phụ: " . mysqli_error($mysqli));
            }
        }

        if ($added) {
            $_SESSION['success'] = "Thêm ảnh phụ thành công!";
        } else {
            $_SESSION['error'] = "Thêm ảnh phụ thất bại. Vui lòng kiểm tra log.";
        }
    } else {
        $_SESSION['error'] = "Không có ảnh nào được upload.";
    }
    header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh');
    exit;
}

// ================== SỬA ẢNH PHỤ ==================
elseif (isset($_POST['sua_anhphu'])) {
    $id_anhphu = (int)($_POST['id_anhphu'] ?? 0);
    $id_sanpham = (int)($_POST['id_sanpham'] ?? 0);
    $thutu_hien_thi = (int)($_POST['thutu_hien_thi'] ?? 0);
    $hinhanh_phu = $_FILES['hinhanh_phu'] ?? [];

    if ($id_anhphu <= 0 || $id_sanpham <= 0) {
        $_SESSION['error'] = "ID không hợp lệ.";
        header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanhphu&id_sanpham=' . $id_sanpham);
        exit;
    }

    $sql_old = "SELECT duong_dan FROM anhphu WHERE id_anhphu = ? LIMIT 1";
    $stmt_old = mysqli_prepare($mysqli, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "i", $id_anhphu);
    mysqli_stmt_execute($stmt_old);
    $result_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($result_old);
    $old_duong_dan = $row_old['duong_dan'] ?? '';

    $new_duong_dan = $old_duong_dan;
    if (!empty($hinhanh_phu['name'])) {
        $new_duong_dan = uploadImage($hinhanh_phu, 'anhphuuploads/');
        if ($new_duong_dan && !empty($old_duong_dan) && file_exists(__DIR__ . '/' . $old_duong_dan)) {
            unlink(__DIR__ . '/' . $old_duong_dan);
        }
    }

    $sql_update = "UPDATE anhphu SET duong_dan = ?, thutu_hien_thi = ? WHERE id_anhphu = ?";
    $stmt_update = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sii", $new_duong_dan, $thutu_hien_thi, $id_anhphu);
    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['success'] = "Cập nhật ảnh phụ thành công!";
    } else {
        $_SESSION['error'] = "Cập nhật ảnh phụ thất bại: " . mysqli_error($mysqli);
    }
    header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh&id_sanpham=' . $id_sanpham);
    exit;
}

// ================== XOÁ ẢNH PHỤ ==================
elseif (isset($_GET['query']) && $_GET['query'] == 'xoa_anhphu') {
    $id_anhphu = (int)($_GET['id_anhphu'] ?? 0);
    $id_sanpham = (int)($_GET['id_sanpham'] ?? 0);

    if ($id_anhphu <= 0 || $id_sanpham <= 0) {
        $_SESSION['error'] = "ID không hợp lệ.";
        header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh&id_sanpham=' . $id_sanpham);
        exit;
    }

    $sql = "SELECT duong_dan FROM anhphu WHERE id_anhphu = ? LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_anhphu);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && !empty($row['duong_dan']) && file_exists(__DIR__ . '/' . $row['duong_dan'])) {
        unlink(__DIR__ . '/' . $row['duong_dan']);
    }

    $sql_xoa = "DELETE FROM anhphu WHERE id_anhphu = ?";
    $stmt_xoa = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt_xoa, "i", $id_anhphu);
    if (mysqli_stmt_execute($stmt_xoa)) {
        $_SESSION['success'] = "Xóa ảnh phụ thành công!";
    } else {
        $_SESSION['error'] = "Xóa ảnh phụ thất bại: " . mysqli_error($mysqli);
    }
    header('Location: ../../indexad.php?action=quanlyanhphu&query=lietkeanh&id_sanpham=' . $id_sanpham);
    exit;
}

ob_end_flush();