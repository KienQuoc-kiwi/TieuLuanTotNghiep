<?php
include('../config/config.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
 <div class="quanly-sp">
    <h2 class="tieude-them-sp">Thêm Sản Phẩm</h2>
    <form id="form-them-sp" enctype="multipart/form-data" action="modules/quanlysp/xuly.php" method="POST" class="form-them-sp">
        <table class="bang-them-sp">
            <tr>
                <td class="ten-truong"><strong>Tên Sản Phẩm</strong></td>
                <td class="gia-tri-truong"><input type="text" name="tensanpham" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Mã Sản Phẩm</strong></td>
                <td class="gia-tri-truong"><input type="text" name="masp" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Giá Sản Phẩm</strong></td>
                <td class="gia-tri-truong"><input type="number" name="giasp" min="0" step="1000" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Số Lượng</strong></td>
                <td class="gia-tri-truong"><input type="number" name="soluong" min="0" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Ảnh Sản Phẩm</strong></td>
                <td class="gia-tri-truong"><input type="file" name="hinhanh" accept="image/*" required /></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Tóm Tắt</strong></td>
                <td class="gia-tri-truong"><textarea name="tomtat" rows="4" required></textarea></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Nội Dung</strong></td>
                <td class="gia-tri-truong"><textarea name="noidung" rows="5" required></textarea></td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Danh Mục</strong></td>
                <td class="gia-tri-truong">
                    <select name="danhmuc" id="danhmuc-them" onchange="loadSubcategories()" required>
                        <option value="">Chọn Danh Mục</option>
                        <?php
                        $sql_danhmuc = "SELECT * FROM danhmuc ORDER BY id_danhmuc DESC";
                        $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                            echo '<option value="' . htmlspecialchars($row_danhmuc['id_danhmuc']) . '">' . htmlspecialchars($row_danhmuc['tendanhmuc']) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Danh Mục Con</strong></td>
                <td class="gia-tri-truong">
                    <select name="danhmuccon" id="danhmuccon-them">
                        <option value="">Chọn Danh Mục Con</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="ten-truong"><strong>Trạng Thái</strong></td>
                <td class="gia-tri-truong">
                    <select name="tinhtrang" required>
                        <option value="1">Kích Hoạt</option>
                        <option value="0">Ẩn</option>
                    </select>
                </td>
            </tr>
        </table>
        <br><br>
        <input type="submit" name="themsp" value="Thêm Sản Phẩm" class="nut-xac-nhan">
    </form>
</div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function loadSubcategories() {
                const id_danhmuc = $('#danhmuc').val();
                if (!id_danhmuc) {
                    $('#danhmuccon').html('<option value="">Chọn Danh Mục Con</option>');
                    return;
                }
                $.ajax({
                    url: 'modules/quanlysp/nhandanhmuc.php',
                    type: 'POST',
                    data: { id_danhmuc: id_danhmuc },
                    dataType: 'json',
                    success: function(data) {
                        const subcategorySelect = $('#danhmuccon');
                        subcategorySelect.html('<option value="">Chọn Danh Mục Con</option>');
                        if (data && Array.isArray(data)) {
                            data.forEach(sub => {
                                subcategorySelect.append(`<option value="${sub.id_danhmuccon}">${sub.ten_danhmuccon}</option>`);
                            });
                        } else {
                            console.error('Dữ liệu không hợp lệ:', data);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        alert('Lỗi khi tải danh mục con. Vui lòng kiểm tra kết nối hoặc liên hệ quản trị viên.');
                    }
                });
            }
        </script>

        <style>
            .form-label { font-weight: bold; }
            .form-control { width: 100%; padding: 8px; margin-bottom: 10px; }
            table { width: 100%; border-collapse: collapse; }
            table td { padding: 10px; }
            input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 5px; }
        </style>
    </div>
</body>
</html>