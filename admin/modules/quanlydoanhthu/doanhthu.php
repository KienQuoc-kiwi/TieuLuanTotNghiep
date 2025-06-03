<?php
include('../config/config.php');

// Doanh thu hôm nay
$today = date('Y-m-d');
$sql_today = "
    SELECT SUM(ctdh.soluong * sp.giasp) AS doanhthu_ngay
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE DATE(dh.ngaytao) = '$today'
";

// Doanh thu tháng này
$month = date('m');
$year = date('Y');
$sql_month = "
    SELECT SUM(ctdh.soluong * sp.giasp) AS doanhthu_thang
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE MONTH(dh.ngaytao) = '$month' AND YEAR(dh.ngaytao) = '$year'
";

// Thực thi
$query_today = mysqli_query($mysqli, $sql_today);
$query_month = mysqli_query($mysqli, $sql_month);

$row_today = mysqli_fetch_assoc($query_today);
$row_month = mysqli_fetch_assoc($query_month);

$doanhthu_ngay = $row_today['doanhthu_ngay'] ?? 0;
$doanhthu_thang = $row_month['doanhthu_thang'] ?? 0;
?>

<!-- Font Awesome + Chart.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background-color: #f4f7fa;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 20px;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding-left: 80px;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    text-align: center;
}

.card .icon {
    font-size: 24px;
    margin-bottom: 10px;
    color: #4e73df;
}

.card .label {
    font-size: 14px;
    color: #888;
}

.card .value {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.chart-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}
</style>

<div class="dashboard-container">
    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <div class="icon"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="label">Doanh thu hôm nay</div>
            <div class="value"><?php echo number_format($doanhthu_ngay, 0, ',', '.'); ?> VNĐ</div>
        </div>
        <div class="card">
            <div class="icon"><i class="fa-solid fa-calendar-alt"></i></div>
            <div class="label">Doanh thu tháng này</div>
            <div class="value"><?php echo number_format($doanhthu_thang, 0, ',', '.'); ?> VNĐ</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-container">
        <canvas id="doanhThuChart" height="100"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('doanhThuChart').getContext('2d');
const doanhThuChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['01', '02', '03', '04', '05', '06', '07'], // Ngày
        datasets: [{
            label: 'Doanh thu theo ngày',
            data: [3500000, 10000000, 50000000, 100000000, 200000000, 300000000, 400000000], // Thay bằng dữ liệu PHP nếu có
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString("vi-VN") + " VNĐ";
                    }
                }
            }
        }
    }
});
</script>
