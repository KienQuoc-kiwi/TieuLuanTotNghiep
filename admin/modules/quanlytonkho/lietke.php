<?php
include('../config/config.php');
?>

<div class="tonkho">
    <h2 class="tieude-danhsach-tonkho">Danh sách tồn kho</h2>
    <table class="bang-danhsach-tonkho">
        <tr>
            <th class="cot-id-tonkho">ID</th>
            <th class="cot-ten-sanpham">Sản phẩm</th>
            <th class="cot-masp-tonkho">Mã sản phẩm</th>
            <th class="cot-soluong-tonkho">Tồn kho</th>
            <th class="cot-danhmuc-tonkho">Danh mục</th>
            <th class="cot-canhbao-tonkho">Cảnh báo</th>
            <th class="cot-quanly-tonkho">Quản lý</th>
        </tr>
        <?php
        $sql = "SELECT s.id_sanpham, s.tensanpham, s.masp, s.soluong, d.tendanhmuc
                FROM sanpham s
                JOIN danhmuc d ON s.id_danhmuc = d.id_danhmuc
                ORDER BY s.id_sanpham DESC";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $canhbao = ($row['soluong'] < 10) ? '<span class="canhbao-thap">Thấp</span>' : '';
        ?>
            <tr>
                <td class="gia-tri-id-tonkho"><?php echo $row['id_sanpham']; ?></td>
                <td class="gia-tri-ten-sanpham"><?php echo htmlspecialchars($row['tensanpham']); ?></td>
                <td class="gia-tri-masp-tonkho"><?php echo htmlspecialchars($row['masp']); ?></td>
                <td class="gia-tri-soluong-tonkho"><?php echo $row['soluong']; ?></td>
                <td class="gia-tri-danhmuc-tonkho"><?php echo htmlspecialchars($row['tendanhmuc']); ?></td>
                <td class="gia-tri-canhbao-tonkho"><?php echo $canhbao; ?></td>
                <td class="gia-tri-quanly-tonkho">
                    <a class="nut-dieuchinh-tonkho" href="indexad.php?action=quanlytonkho&query=sua&id_sanpham=<?php echo $row['id_sanpham']; ?>">Điều chỉnh</a> |
                    <a class="nut-xemchitiet-tonkho" href="indexad.php?action=quanlytonkho&query=chitiet&id_sanpham=<?php echo $row['id_sanpham']; ?>">Xem chi tiết</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
