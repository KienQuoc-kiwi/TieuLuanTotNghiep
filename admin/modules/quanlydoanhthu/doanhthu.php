<?php
include('../config/config.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Doanh thu</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="quanlydoanhthu.css">
</head>
<body>
<!-- <header>
    <img src="logo-placeholder.png" alt="Logo" class="logo">
</header> -->
<div class="dashboard-container">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center">
            <i class="fa-solid fa-chart-line mr-2"></i> Quản lý Doanh thu
        </h1>
        <p class="text-gray-600 mt-2">Chọn để xem thống kê doanh thu chi tiết</p>
    </div>

    <!-- Buttons -->
    <div class="cards">
        <!-- Doanh thu ngày -->
        <div class="card">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center justify-center">
                <i class="fa-solid fa-calendar-day mr-2 text-gray-600"></i> Doanh thu ngày
            </h2>
            <a href="modules/quanlydoanhthu/doanhthungay.php" class="card-button">
                <i class="fa-solid fa-eye"></i> Xem doanh thu
            </a>
        </div>

        <!-- Doanh thu tháng -->
        <div class="card">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center justify-center">
                <i class="fa-solid fa-calendar-alt mr-2 text-gray-600"></i> Doanh thu tháng
            </h2>
            <a href="modules/quanlydoanhthu/doanhthuthang.php" class="card-button">
                <i class="fa-solid fa-eye"></i> Xem doanh thu
            </a>
        </div>

        <!-- Doanh thu năm -->
        <div class="card">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center justify-center">
                <i class="fa-solid fa-calendar mr-2 text-gray-600"></i> Doanh thu năm
            </h2>
            <a href="modules/quanlydoanhthu/doanhthunam.php" class="card-button">
                <i class="fa-solid fa-eye"></i> Xem doanh thu
            </a>
        </div>
    </div>
</div>
</body>
</html>