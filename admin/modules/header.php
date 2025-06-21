<div class="header">
    <!-- Nút toggle menu -->
    <div class="menu-toggle" id="menuToggle">☰</div>

    <!-- Logo -->
    <div class="logo">
        <a href="indexad.php" style="color: white; text-decoration: none;">
            <img src="../img/logoquanly.png" alt="Logo" style="height: 40px; vertical-align: middle;">
            <span style="margin-left: 10px; font-weight: 600;">
                CHÀO MỪNG BẠN ĐẾN VỚI TRANG QUẢN LÝ WEBSITE BÁN GIÀY
            </span>
        </a>
    </div>

    <!-- Admin Info -->
    <div class="admin-info">
        <?php
        if (isset($_SESSION['dangkyk'])) {
            echo '<span>Xin chào, <strong>' . $_SESSION['dangkyk'] . '</strong></span> | ';
            echo '<a href="../page/main/dangnhapkhach.php" style="color: #61dafb; text-decoration: none;">Đăng xuất</a>';
        }
        ?>
    </div>
</div>
