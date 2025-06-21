<?php
require 'config/config.php'; // File kết nối database
?>
<header data-auto-id="header" class="header-index">
    <div class="header-bottom">
        <a href="index.php"><img src="img/logo.png" alt=""></a>
        <ul class="list-header">
            <?php
            $sql = "SELECT * FROM danhmuc ORDER BY thutu ASC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li class="navigation nav-dropdown">' . htmlspecialchars($row['tendanhmuc']);
                $sql_sub = "SELECT * FROM danhmuccon WHERE id_danhmuc = " . $row['id_danhmuc'];
                $result_sub = mysqli_query($mysqli, $sql_sub);
                if (mysqli_num_rows($result_sub) > 0) {
                    echo '<ul class="submenu">';
                    while ($sub_row = mysqli_fetch_assoc($result_sub)) {
                        echo '<li><a href="index.php?quanly=danhmucsanpham&id_danhmuc=' . $row['id_danhmuc'] . '&id_danhmuccon=' . $sub_row['id_danhmuccon'] . '">' . htmlspecialchars($sub_row['ten_danhmuccon']) . '</a></li>';
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }
            ?>
            <!-- <li class="navigation"><a href="#" class="navigation">KHUYẾN MÃI</a></li> -->
            <li class="navigation">
                <a href="index.php?quanly=lichsudonhang" class="navigation">Lịch sử đơn hàng</a>
            </li>
        </ul>

        <div class="auxiliary-menu">
            <div class="wrapper">
                <form method="POST" action="index.php?quanly=timkiem">
                    <input type="text" name="tukhoa" class="input-find" placeholder="Tìm kiếm..." required>
                    <div class="search-button">
                        <button type="submit" name="timkiem"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <button aria-label="Đăng ký hoặc đăng nhập" class="user-icon">
            <div class="gl-icon"><a href="page/main/dangnhapkhach.php"><i class="fa-regular fa-user"></i></a></div>
            <span aria-hidden="true" data-auto-id="profile-notification-count" class="_notification_kwit6_1">1</span>
        </button>
        <a href="" class="gl-icon-wrapper"><i class="fa-regular fa-heart"></i></a>
        <a aria-label="Đi đến giỏ hàng" manual_cm_sp="header-_-Thanh toán" href="index.php?quanly=giohang" class="cart"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</header>