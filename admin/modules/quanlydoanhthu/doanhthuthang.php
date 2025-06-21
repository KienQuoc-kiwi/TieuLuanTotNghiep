<?php
include('../../../config/config.php');

// Lấy năm, tháng được chọn
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

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

// Doanh thu tháng được chọn
$sql_month = "
    SELECT SUM(ctdh.soluong * sp.giasp) AS doanhthu_thang
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE MONTH(dh.ngaytao) = ? AND YEAR(dh.ngaytao) = ? AND dh.trangthai = 1
";
$stmt_month = $mysqli->prepare($sql_month);
if (!$stmt_month) {
    die("Lỗi truy vấn doanh thu: " . $mysqli->error);
}
$stmt_month->bind_param("ii", $month, $year);
$stmt_month->execute();
$result_month = $stmt_month->get_result();
$row_month = $result_month->fetch_assoc();
$doanhthu_thang = $row_month['doanhthu_thang'] ?? 0;

// Doanh thu theo ngày trong tháng
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$doanhthu_ngay = array_fill(1, $days_in_month, 0);
$sql_days = "
    SELECT DAY(dh.ngaytao) AS day, SUM(ctdh.soluong * sp.giasp) AS doanhthu
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE MONTH(dh.ngaytao) = ? AND YEAR(dh.ngaytao) = ? AND dh.trangthai = 1
    GROUP BY DAY(dh.ngaytao)
";
$stmt_days = $mysqli->prepare($sql_days);
if (!$stmt_days) {
    die("Lỗi truy vấn ngày: " . $mysqli->error);
}
$stmt_days->bind_param("ii", $month, $year);
$stmt_days->execute();
$result_days = $stmt_days->get_result();
while ($row = $result_days->fetch_assoc()) {
    $doanhthu_ngay[$row['day']] = $row['doanhthu'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doanh Thu Tháng</title>
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
            <select name="month" id="month">
                <?php foreach ($months as $m): ?>
                    <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                        Tháng <?php echo $m; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Xem</button>
        </form>
    </div>

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <div class="icon"><i class="fa-solid fa-calendar-alt"></i></div>
            <div class="label">Doanh thu tháng <?php echo sprintf("%02d/%04d", $month, $year); ?></div>
            <div class="value"><?php echo number_format($doanhthu_thang, 0, ',', '.'); ?> VNĐ</div>
        </div>
    </div>

    <!-- No Data Message -->
    <?php if ($doanhthu_thang == 0): ?>
        <div class="no-data">Không có doanh thu trong tháng này (hoặc không có đơn hàng đã xác nhận).</div>
    <?php endif; ?>

    <!-- Chart -->
    <div class="chart-container">
        <canvas id="doanhThuNgayChart" height="100"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('doanhThuNgayChart').getContext('2d');
const doanhThuNgayChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Array.from({length: <?php echo $days_in_month; ?>}, (_, i) => i + 1),
        datasets: [{
            label: 'Doanh thu theo ngày',
            data: <?php echo json_encode(array_values($doanhthu_ngay)); ?>,
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