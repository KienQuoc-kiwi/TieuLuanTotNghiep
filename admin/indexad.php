<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý</title>
    <link rel="stylesheet" href="css/stylead.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/quanlysp.css">
    <link rel="stylesheet" href="css/quanlydanhmuc.css">
    <link rel="stylesheet" href="css/quanlyanhphu.css">
    <link rel="stylesheet" href="css/quanlynhanvien.css">
    <link rel="stylesheet" href="css/quanlydoanhthu.css">
    <link rel="stylesheet" href="css/quanlybienthe.css">
    <link rel="stylesheet" href="css/quanlytonkho.css">
    <link rel="stylesheet" href="css/quanlydonhang.css">
    <link rel="stylesheet" href="css/menuadmin.css">
    <link rel="stylesheet" href="css/indexad.css">
    <link rel="stylesheet" href="css/quanlykhach.css">
</head>
<body>
    <div class="wrapper">
        <?php
            include("../config/config.php");
            include("modules/header.php");
            include("modules/menu.php");
            include("modules/main.php");
            include("modules/footer.php");
        ?>
    </div>

    <!-- Chỉ nơi này chứa JS thao tác với menu -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById('menuToggle');
            const menu = document.getElementById('sidebarMenu');

            if (toggle && menu) {
                toggle.addEventListener('mouseenter', () => {
                    menu.classList.add('show');
                });

                menu.addEventListener('mouseleave', () => {
                    menu.classList.remove('show');
                });
            } else {
                console.warn('Không tìm thấy phần tử menuToggle hoặc sidebarMenu');
            }
        });
    </script>
</body>
</html>
