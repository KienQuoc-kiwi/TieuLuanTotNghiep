<?php
include('../../../config/config.php');

// Thêm sản phẩm chính và các biến thể từ form thêm sản phẩm
if (isset($_POST['themsanpham'])) {
    // 1. Lấy dữ liệu sản phẩm chính
    $tensanpham = $_POST['tensanpham'];
    $masp = $_POST['masp'];
    $giasp = $_POST['giasp'];
    $soluong = $_POST['soluong'];
    $tomtat = $_POST['tomtat'];
    $danhmuc = $_POST['danhmuc'];
    $tinhtrang = $_POST['tinhtrang'];
    //xuly hinh anh
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $hinhanh = time() . '_' . $hinhanh;

    // 2. Xử lý ảnh sản phẩm chính
    // $hinhanh = '';
    // if (isset($_FILES['hinhanh']['name']) && $_FILES['hinhanh']['name'] != '') {
    //     $hinhanh = time() . '_' . $_FILES['hinhanh']['name'];
    //     move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'uploads/' . $hinhanh);
    // }

    // 3. Thêm sản phẩm chính vào bảng `sanpham`
    $sql_themsp = "INSERT INTO sanpham(tensanpham, masp, giasp, soluong, hinhanh, tomtat, id_danhmuc, tinhtrang)
                   VALUES('$tensanpham', '$masp', '$giasp', '$soluong', '$hinhanh', '$tomtat', '$danhmuc', '$tinhtrang')";
    mysqli_query($mysqli, $sql_themsp);
    move_uploaded_file($hinhanh_tmp, '../quanlysp/uploads/' . $hinhanh);
    header('Location:../../indexad.php?action=quanlysanpham&query=them');

    // 4. Lấy ID sản phẩm vừa thêm
    $id_sanpham = mysqli_insert_id($mysqli);

    // 5. Duyệt mảng biến thể (nếu có) và thêm vào bảng `bienthesanpham`
    if (isset($_POST['variants'])) {
        foreach ($_POST['variants'] as $index => $variant) {
            $kichco = mysqli_real_escape_string($mysqli, $variant['kichco']);
            $mausac = mysqli_real_escape_string($mysqli, $variant['mausac']);
            $soluongtonkho = (int)$variant['soluongtonkho'];
            $madinhdanh = !empty($variant['madinhdanh']) ? mysqli_real_escape_string($mysqli, $variant['madinhdanh']) : uniqid();

            // 6. Xử lý ảnh biến thể
            $hinhanh_bienthe = '';
            if (isset($_FILES['variant_images']['name'][$index]) && $_FILES['variant_images']['name'][$index] != '') {
                $hinhanh_bienthe = time() . '_' . $_FILES['variant_images']['name'][$index];
                move_uploaded_file($_FILES['variant_images']['tmp_name'][$index], 'uploads/' . $hinhanh_bienthe);
            }

            // 7. Chỉ thêm nếu có dữ liệu kích cỡ hoặc màu sắc
            if (!empty($kichco) || !empty($mausac)) {
                $sql_variant = "INSERT INTO bienthesanpham(kichco, mausac, soluongtonkho, madinhdanh, hinhanh, id_sanpham)
                                VALUES('$kichco', '$mausac', '$soluongtonkho', '$madinhdanh', '$hinhanh_bienthe', '$id_sanpham')";
                mysqli_query($mysqli, $sql_variant);
            }
        }
    }

    header('Location: ../../indexad.php?action=quanlysanpham&query=them');
    exit;
}


// Thêm biến thể riêng (từ giao diện quản lý biến thể)
if (isset($_POST['thembienthe'])) {
    $kichco = $_POST['kichco'];
    $mausac = $_POST['mausac'];
    $soluongtonkho = $_POST['soluongtonkho'];
    $madinhdanh = $_POST['madinhdanh'];
    $id_sanpham = $_POST['id_sanpham'];

    // Xử lý ảnh
    $hinhanh = '';
    if (isset($_FILES['hinhanh']['name']) && $_FILES['hinhanh']['name'] != '') {
        $hinhanh = time() . '_' . $_FILES['hinhanh']['name'];
        move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'uploads/' . $hinhanh);
    }

    $sql_them = "INSERT INTO bienthesanpham(kichco, mausac, soluongtonkho, madinhdanh, hinhanh, id_sanpham)
                 VALUES('$kichco', '$mausac', '$soluongtonkho', '$madinhdanh', '$hinhanh', '$id_sanpham')";
    mysqli_query($mysqli, $sql_them);
    header('Location: ../../indexad.php?action=quanlybienthe&query=them');
    exit;
}


// Sửa biến thể
if (isset($_POST['suabienthe'])) {
    $id_bienthe = $_GET['id_bienthe'];
    $kichco = $_POST['kichco'];
    $mausac = $_POST['mausac'];
    $soluongtonkho = $_POST['soluongtonkho'];
    $madinhdanh = $_POST['madinhdanh'];
    $id_sanpham = $_POST['id_sanpham'];

    // Kiểm tra ảnh mới
    if (isset($_FILES['hinhanh']['name']) && $_FILES['hinhanh']['name'] != '') {
        $hinhanh = time() . '_' . $_FILES['hinhanh']['name'];
        move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'uploads/' . $hinhanh);

        // Xóa ảnh cũ
        $sql = "SELECT * FROM bienthesanpham WHERE id_bienthe = '$id_bienthe' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            if (!empty($row['hinhanh']) && file_exists('uploads/' . $row['hinhanh'])) {
                unlink('uploads/' . $row['hinhanh']);
            }
        }

        // Cập nhật có ảnh mới
        $sql_update = "UPDATE bienthesanpham SET kichco='$kichco', mausac='$mausac', soluongtonkho='$soluongtonkho',
                       madinhdanh='$madinhdanh', hinhanh='$hinhanh', id_sanpham='$id_sanpham'
                       WHERE id_bienthe='$id_bienthe'";
    } else {
        // Không cập nhật ảnh
        $sql_update = "UPDATE bienthesanpham SET kichco='$kichco', mausac='$mausac', soluongtonkho='$soluongtonkho',
                       madinhdanh='$madinhdanh', id_sanpham='$id_sanpham'
                       WHERE id_bienthe='$id_bienthe'";
    }

    mysqli_query($mysqli, $sql_update);
    header('Location: ../../indexad.php?action=quanlybienthe&query=them');
    exit;
}


// Xóa biến thể
if (isset($_GET['id_bienthe']) && !isset($_POST['suabienthe'])) {
    $id = $_GET['id_bienthe'];

    // Xoá ảnh
    $sql = "SELECT * FROM bienthesanpham WHERE id_bienthe = '$id' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_array($query)) {
        if (!empty($row['hinhanh']) && file_exists('uploads/' . $row['hinhanh'])) {
            unlink('uploads/' . $row['hinhanh']);
        }
    }

    $sql_xoa = "DELETE FROM bienthesanpham WHERE id_bienthe = '$id'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location: ../../indexad.php?action=quanlybienthe&query=them');
    exit;
}
