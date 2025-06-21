<?php
// session_start();
if (!isset($_SESSION['id_vaitro'])) {
    header("Location: dangnhapkhach.php");
    exit();
}
?>

<!-- Menu -->
<div class="menu" id="sidebarMenu">
    <!-- <a href="indexad.php"><img src="../img/logoquanly.png" alt="Logo lỗi"></a> -->
    <ul class="admincp_list">
        <li><a href="indexad.php?action=quanlydanhmucsanpham&query=them">Quản lý danh mục sản phẩm</a></li>
        <li><a href="indexad.php?action=quanlysanpham&query=lietke">Quản lý sản phẩm</a></li>
        <li><a href="indexad.php?action=quanlydonhang&query=lietke">Quản lý đơn hàng</a></li>
        <?php if ($_SESSION['id_vaitro'] == 1) { ?>
            <li><a href="indexad.php?action=quanlynhanvien&query=lietke">Quản lý nhân viên</a></li>
        <?php } ?>
        <li><a href="indexad.php?action=quanlykhach&query=lietke">Quản lý khách hàng</a></li>
        <li><a href="indexad.php?action=quanlybienthe&query=lietke">Quản lý biến thể sản phẩm</a></li>
        <li><a href="indexad.php?action=quanlyanhphu&query=lietkeanh">Quản lý ảnh phụ sản phẩm</a></li>
        <li><a href="indexad.php?action=quanlytonkho&query=lietke">Quản lý tồn kho sản phẩm</a></li>
        <li><a href="indexad.php?action=quanlydoanhthu&query=lietke">📊 Quản lý doanh thu</a></li>
    </ul>
</div>