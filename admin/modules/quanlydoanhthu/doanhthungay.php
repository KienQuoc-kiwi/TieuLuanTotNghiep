<?php
include('../../../config/config.php');

// Lấy tháng, năm, ngày được chọn
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$day = isset($_GET['day']) ? (int)$_GET['day'] : date('d');

// Lấy danh sách năm
$sql_years = "SELECT DISTINCT YEAR(ngaytao) AS year FROM donhang WHERE trangthai = 1 ORDER BY year DESC";
$result_years = $mysqli->query($sql_years);
$years = [];
while ($row = $result_years->fetch_assoc()) {
    $years[] = $row['year'];
}
if (empty($years)) {
    $years = [date('Y')];
}

// Lấy danh sách tháng trong năm được chọn
$sql_months = "SELECT DISTINCT MONTH(ngaytao) AS month FROM donhang WHERE YEAR(ngaytao) = ? AND trangthai = 1 ORDER BY month";
$stmt_months = $mysqli->prepare($sql_months);
$stmt_months->bind_param("i", $year);
$stmt_months->execute();
$result_months = $stmt_months->get_result();
$months = [];
while ($row = $result_months->fetch_assoc()) {
    $months[] = $row['month'];
}
if (empty($months)) {
    $months = [date('m')];
}

// Lấy danh sách ngày trong tháng
$sql_days = "SELECT DISTINCT DAY(ngaytao) AS day FROM donhang WHERE MONTH(ngaytao) = ? AND YEAR(ngaytao) = ? AND trangthai = 1 ORDER BY day";
$stmt_days = $mysqli->prepare($sql_days);
$stmt_days->bind_param("ii", $month, $year);
$stmt_days->execute();
$result_days = $stmt_days->get_result();
$days = [];
while ($row = $result_days->fetch_assoc()) {
    $days[] = $row['day'];
}
if (empty($days)) {
    $days = [date('d')];
}

// Doanh thu ngày được chọn
$date = sprintf("%04d-%02d-%02d", $year, $month, $day);
$sql_day = "
    SELECT SUM(ctdh.soluong * sp.giasp) AS doanhthu_ngay
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE DATE(dh.ngaytao) = ? AND dh.trangthai = 1
";
$stmt_day = $mysqli->prepare($sql_day);
if (!$stmt_day) {
    die("Lỗi truy vấn doanh thu: " . $mysqli->error);
}
$stmt_day->bind_param("s", $date);
$stmt_day->execute();
$result_day = $stmt_day->get_result();
$row_day = $result_day->fetch_assoc();
$doanhthu_ngay = $row_day['doanhthu_ngay'] ?? 0;

// Doanh thu theo giờ
$doanhthu_gio = array_fill(0, 24, 0);
$sql_hours = "
    SELECT HOUR(dh.ngaytao) AS hour, SUM(ctdh.soluong * sp.giasp) AS doanhthu
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE DATE(dh.ngaytao) = ? AND dh.trangthai = 1
    GROUP BY HOUR(dh.ngaytao)
";
$stmt_hours = $mysqli->prepare($sql_hours);
if (!$stmt_hours) {
    die("Lỗi truy vấn giờ: " . $mysqli->error);
}
$stmt_hours->bind_param("s", $date);
$stmt_hours->execute();
$result_hours = $stmt_hours->get_result();
while ($row = $result_hours->fetch_assoc()) {
    $doanhthu_gio[$row['hour']] = $row['doanhthu'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doanh Thu Ngày</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="quanlydoanhthu.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<!-- <header>
    <img src="logo-placeholder.png" alt="Logo" class="logo">
</header> -->
<div class="dashboard-container">
    <!-- Back Button -->
    <a href="../../indexad.php?action=quanlydoanhthu&query=lietke" class="back-button"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>

    <!-- Filter -->
    <div class="filter">
        <form method="GET">
            <label for="year">Năm: </label>
            <select name="year" id="year" onchange="this.form.submit()">
                <?php foreach ($years as $y): ?>
                    <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>>
                        <?php echo $y; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="month">Tháng: </label>
            <select name="month" id="month" onchange="this.form.submit()">
                <?php foreach ($months as $m): ?>
                    <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                        Tháng <?php echo $m; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="day">Ngày: </label>
            <select name="day" id="day">
                <?php foreach ($days as $d): ?>
                    <option value="<?php echo $d; ?>" <?php echo $d == $day ? 'selected' : ''; ?>>
                        Ngày <?php echo $d; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Xem</button>
        </form>
    </div>

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <div class="icon"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="label">Doanh thu ngày <?php echo sprintf("%02d/%02d/%04d", $day, $month, $year); ?></div>
            <div class="value"><?php echo number_format($doanhthu_ngay, 0, ',', '.'); ?> VNĐ</div>
        </div>
    </div>

    <!-- No Data Message -->
    <?php if ($doanhthu_ngay == 0): ?>
        <div class="no-data">Không có doanh thu trong ngày này (hoặc không có đơn hàng đã xác nhận).</div>
    <?php endif; ?>

    <!-- Chart -->
    <div class="chart-container">
        <canvas id="doanhThuGioChart" height="100"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('doanhThuGioChart').getContext('2d');
const doanhThuGioChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Array.from({length: 24}, (_, i) => i + ':00'),
        datasets: [{
            label: 'Doanh thu theo giờ',
            data: <?php echo json_encode(array_values($doanhthu_gio)); ?>,
            backgroundColor: 'rgba(52, 58, 64, 0.5)',
            borderColor: '#343A40',
            borderWidth: 1
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
</body>
</html>