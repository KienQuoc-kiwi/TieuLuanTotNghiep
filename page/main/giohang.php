<p>Giỏ hàng</p>

<?php
if (isset($_SESSION['dangkyk'])) {
    echo 'Xin chào: <span style="color:red;">' . $_SESSION['dangkyk'] . '</span>';
    echo ' | ID: ' . $_SESSION['id_khach'];
}
?>

<table style="width:100%; text-align:center; border-collapse:collapse;" border="1">
    <tr>
        <th>STT</th>
        <th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Kích cỡ</th>
        <th>Màu sắc</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Thành tiền</th>
        <th>Quản lý</th>
    </tr>

    <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $i = 0;
        $tongtien = 0;
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            $i++;
            $thanhtien = $cart_item['soluong'] * $cart_item['giasp'];
            $tongtien += $thanhtien;

            // Mã sản phẩm theo key hoặc id
            $masp = $cart_item['id'] ?? $key;
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $masp; ?></td>
            <td><?php echo $cart_item['tensanpham']; ?></td>
            <td><img src="admin/modules/quanlysp/uploads/<?php echo $cart_item['hinhanh']; ?>" width="100px"></td>
            <td><?php echo $cart_item['kichco']; ?></td>
            <td><?php echo $cart_item['mausac']; ?></td>
            <td>
                <a href="page/main/themgiohang.php?tru=<?php echo $key; ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
                <?php echo $cart_item['soluong']; ?>
                <a href="page/main/themgiohang.php?cong=<?php echo $key; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </td>
            <td><?php echo number_format($cart_item['giasp'], 0, ',', '.') . ' vnđ'; ?></td>
            <td><?php echo number_format($thanhtien, 0, ',', '.') . ' vnđ'; ?></td>
            <td><a href="page/main/themgiohang.php?xoa=<?php echo $key; ?>">Xóa</a></td>
        </tr>
    <?php
        }
    ?>
        <tr>
            <td colspan="10">
                <p style="float:left;">Tổng tiền: <strong><?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></strong></p>
                <p style="float:right;"><a href="page/main/themgiohang.php?xoatatca=1">Xóa tất cả sản phẩm</a></p>
                <div style="clear:both;"></div>

                <?php if (isset($_SESSION['dangkyk'])) { ?>
                    <p><a href="page/main/thanhtoan.php"><input class="dathang" type="submit" name="dathang" value="Đặt hàng"></a></p>
                <?php } else { ?>
                    <p><a href="page/main/dangkykhach.php?quanly=dangkyk"><input class="dangkydathang" type="submit" name="dangkydathang" value="Đăng ký Đặt hàng"></a></p>
                <?php } ?>
            </td>
        </tr>
    <?php
    } else {
    ?>
        <tr>
            <td colspan="10"><p>Hiện tại giỏ hàng đang trống.</p></td>
        </tr>
    <?php
    }
    ?>
</table>

<style>
    table {
        margin-top: 20px;
        font-family: Arial, sans-serif;
    }
    th {
        background-color: #f2f2f2;
    }
    .dathang, .dangkydathang {
        padding: 10px 20px;
        background-color: black;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
