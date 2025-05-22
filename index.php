<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS chính -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin/css/pro.css">
    <link rel="stylesheet" href="admin/css/footer.css">
    <link rel="stylesheet" href="admin/css/listheader.css">
    <!-- <link rel="stylesheet" href="admin/css/swipper.css"> -->

    <!-- Font + Icon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <title>KIWI Shop</title>
</head>

<body>
    <div class="index">
        <?php
        session_start();
        include('config/config.php');
        include('header.php');
        // include('main.php');
        include('include.php');
        include('footer.php');
        ?>
    </div>

    <!-- Swiper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- File JS khởi tạo Swiper (nếu bạn đã tạo file này trong thư mục js/) -->
    <script src="swiper.js"></script>
</body>

</html>
