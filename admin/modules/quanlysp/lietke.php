<?php include('../config/config.php'); ?>
<div class="quanly-sp">
    <h2 class="tieude-danhsach-sp">Danh sách sản phẩm</h2>
    <table class="bang-danhsach-sp">
        <tr>
            <th class="cot-id">ID</th>
            <th class="cot-ten-sp">Tên sản phẩm</th>
            <th class="cot-ma-sp">Mã sản phẩm</th>
            <th class="cot-gia">Giá</th>
            <th class="cot-soluong">Số lượng</th>
            <th class="cot-anh">Ảnh</th>
            <th class="cot-tomtat">Tóm tắt</th>
            <th class="cot-noidung">Nội dung</th>
            <th class="cot-trangthai">Trạng thái</th>
            <th class="cot-danhmuc">Danh mục</th>
            <th class="cot-danhmuccon">Danh mục con</th>
            <th class="cot-quanly">Quản lý</th>
        </tr>
        <?php
        $sql_select = "SELECT * FROM sanpham ORDER BY id_sanpham DESC";
        $query_select = mysqli_query($mysqli, $sql_select);
        while ($row = mysqli_fetch_array($query_select)) {
            $tomtat = htmlspecialchars($row['tomtat']);
            $noidung = htmlspecialchars($row['noidung']);
            ?>
            <tr>
                <td class="gia-tri-id"><?php echo $row['id_sanpham']; ?></td>
                <td class="gia-tri-ten-sp"><?php echo htmlspecialchars($row['tensanpham']); ?></td>
                <td class="gia-tri-ma-sp"><?php echo htmlspecialchars($row['masp']); ?></td>
                <td class="gia-tri-gia"><?php echo number_format($row['giasp'], 0, ',', '.'); ?></td>
                <td class="gia-tri-soluong"><?php echo $row['soluong']; ?></td>
                <td class="gia-tri-anh"><img src="modules/quanlysp/uploads/<?php echo htmlspecialchars($row['hinhanh']); ?>" width="100" height="100" alt="Ảnh sản phẩm"></td>
                <td class="gia-tri-tomtat" data-full-text="<?php echo $tomtat; ?>">
                    <span class="tomtat-preview"><?php echo $tomtat; ?></span>
                    <a href="#" class="nut-xem-them">Xem thêm</a>
                </td>
                <td class="gia-tri-noidung" data-full-text="<?php echo $noidung; ?>">
                    <span class="noidung-preview"><?php echo $noidung; ?></span>
                    <a href="#" class="nut-xem-them">Xem thêm</a>
                </td>
                <td class="gia-tri-trangthai"><?php echo ($row['tinhtrang'] == 1) ? 'Kích hoạt' : 'Ẩn'; ?></td>
                <td class="gia-tri-danhmuc">
                    <?php 
                    $sql_danhmuc = "SELECT tendanhmuc FROM danhmuc WHERE id_danhmuc = ?";
                    $stmt_danhmuc = mysqli_prepare($mysqli, $sql_danhmuc);
                    mysqli_stmt_bind_param($stmt_danhmuc, "i", $row['id_danhmuc']);
                    mysqli_stmt_execute($stmt_danhmuc);
                    $result_danhmuc = mysqli_stmt_get_result($stmt_danhmuc);
                    $row_danhmuc = mysqli_fetch_assoc($result_danhmuc);
                    echo htmlspecialchars($row_danhmuc['tendanhmuc']);
                    mysqli_stmt_close($stmt_danhmuc);
                    ?>
                </td>
                <td class="gia-tri-danhmuccon">
                    <?php 
                    if ($row['id_danhmuccon']) {
                        $sql_danhmuccon = "SELECT ten_danhmuccon FROM danhmuccon WHERE id_danhmuccon = ?";
                        $stmt_danhmuccon = mysqli_prepare($mysqli, $sql_danhmuccon);
                        mysqli_stmt_bind_param($stmt_danhmuccon, "i", $row['id_danhmuccon']);
                        mysqli_stmt_execute($stmt_danhmuccon);
                        $result_danhmuccon = mysqli_stmt_get_result($stmt_danhmuccon);
                        $row_danhmuccon = mysqli_fetch_assoc($result_danhmuccon);
                        echo htmlspecialchars($row_danhmuccon['ten_danhmuccon']);
                        mysqli_stmt_close($stmt_danhmuccon);
                    } else {
                        echo 'Không có';
                    }
                    ?>
                </td>
                <td class="gia-tri-quanly">
                    <a class="nut-chinh-sua" href="indexad.php?action=quanlysanpham&query=sua&id_sanpham=<?php echo $row['id_sanpham']; ?>">Sửa</a> | 
                    <a class="nut-xoa" href="modules/quanlysp/xuly.php?query=xoa&id_sanpham=<?php echo $row['id_sanpham']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <!-- <a href="indexad.php?action=quanlysanpham&query=them" class="nut-them-sp">Thêm sản phẩm</a> -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cells = document.querySelectorAll('.gia-tri-tomtat, .gia-tri-noidung');
    const maxWidth = 200; // Độ rộng tối đa

    cells.forEach(cell => {
        const preview = cell.querySelector('.tomtat-preview, .noidung-preview');
        const fullText = cell.getAttribute('data-full-text');
        const viewMore = cell.querySelector('.nut-xem-them');

        // Kiểm tra và cắt nội dung nếu vượt quá độ rộng hoặc 20 ký tự
        if (preview.scrollWidth > maxWidth || preview.textContent.length > 20) {
            const shortText = fullText.substring(0, 20) + '...';
            preview.textContent = shortText;
            viewMore.style.display = 'inline'; // Đảm bảo nút hiển thị
        } else {
            viewMore.style.display = 'none'; // Ẩn nút nếu không cần
        }

        viewMore.addEventListener('click', function(e) {
            e.preventDefault();
            if (preview.textContent.includes('...')) {
                preview.textContent = fullText; // Hiển thị toàn bộ
                viewMore.textContent = 'Ẩn bớt';
                preview.style.whiteSpace = 'normal'; // Cho phép xuống dòng khi hiển thị đầy đủ
                preview.style.overflow = 'visible';
                preview.style.textOverflow = 'clip';
            } else {
                preview.textContent = fullText.substring(0, 20) + '...';
                viewMore.textContent = 'Xem thêm';
                preview.style.whiteSpace = 'nowrap'; // Trở lại trạng thái ban đầu
                preview.style.overflow = 'hidden';
                preview.style.textOverflow = 'ellipsis';
            }
        });
    });
});
</script>