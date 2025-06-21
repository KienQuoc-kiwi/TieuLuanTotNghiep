<?php
include('../config/config.php');

$id_sanpham = isset($_GET['id_sanpham']) ? (int)$_GET['id_sanpham'] : 0;
if ($id_sanpham > 0) {
    $sql_sp = "SELECT tensanpham, soluong FROM sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt_sp = mysqli_prepare($mysqli, $sql_sp);
    mysqli_stmt_bind_param($stmt_sp, "i", $id_sanpham);
    mysqli_stmt_execute($stmt_sp);
    $result_sp = mysqli_stmt_get_result($stmt_sp);
    $row_sp = mysqli_fetch_array($result_sp);
    mysqli_stmt_close($stmt_sp);
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}
?>

<div class="tonkho">
    <h2 class="tieude-chitiet-tonkho">Chi tiết tồn kho: <?php echo htmlspecialchars($row_sp['tensanpham']); ?></h2>
    <p class="tong-tonkho">Tổng tồn kho: <?php echo $row_sp['soluong']; ?></p>
    <table class="bang-chitiet-tonkho">
        <tr>
            <th class="cot-id-bienthe">ID biến thể</th>
            <th class="cot-kichco-bienthe">Kích cỡ</th>
            <th class="cot-mausac-bienthe">Màu sắc</th>
            <th class="cot-soluong-bienthe">Tồn kho biến thể</th>
            <th class="cot-canhbao-bienthe">Cảnh báo</th>
        </tr>
        <?php
        $sql = "SELECT id_bienthe, kichco, mausac, soluongtonkho
                FROM bienthesanpham
                WHERE id_sanpham = ?
                ORDER BY id_bienthe DESC";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $total_bienthe = 0;
        while ($row = mysqli_fetch_array($result)) {
            $total_bienthe += $row['soluongtonkho'];
            $canhbao = ($row['soluongtonkho'] < 10) ? '<span class="canhbao-thap">Thấp</span>' : '';
        ?>
            <tr>
                <td class="gia-tri-id-bienthe"><?php echo $row['id_bienthe']; ?></td>
                <td class="gia-tri-kichco-bienthe"><?php echo htmlspecialchars($row['kichco']); ?></td>
                <td class="gia-tri-mausac-bienthe"><?php echo htmlspecialchars($row['mausac']); ?></td>
                <td class="gia-tri-soluong-bienthe"><?php echo $row['soluongtonkho']; ?></td>
                <td class="gia-tri-canhbao-bienthe"><?php echo $canhbao; ?></td>
            </tr>
        <?php
        }
        mysqli_stmt_close($stmt);
        ?>
    </table>
    <?php if ($total_bienthe != $row_sp['soluong']) { ?>
        <p class="canhbao-khongdongbo">Cảnh báo: Tổng tồn kho biến thể (<?php echo $total_bienthe; ?>) không khớp với tồn kho sản phẩm (<?php echo $row_sp['soluong']; ?>).</p>
    <?php } ?>
    <a class="nut-quaylai-tonkho" href="indexad.php?action=quanlytonkho&query=lietke">Quay lại danh sách</a>
</div>
