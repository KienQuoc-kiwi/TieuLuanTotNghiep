<?php
include('../../../config/config.php');

// Lấy năm được chọn
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

// Doanh thu năm được chọn
$sql_year = "
    SELECT SUM(ctdh.soluong * sp.giasp) AS doanhthu_nam
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE YEAR(dh.ngaytao) = ? AND dh.trangthai = 1
";
$stmt_year = $mysqli->prepare($sql_year);
if (!$stmt_year) {
    die("Lỗi truy vấn doanh thu: " . $mysqli->error);
}
$stmt_year->bind_param("i", $year);
$stmt_year->execute();
$result_year = $stmt_year->get_result();
$row_year = $result_year->fetch_assoc();
$doanhthu_nam = $row_year['doanhthu_nam'] ?? 0;

// Doanh thu theo tháng trong năm
$doanhthu_thang = array_fill(1, 12, 0);
$sql_months = "
    SELECT MONTH(dh.ngaytao) AS month, SUM(ctdh.soluong * sp.giasp) AS doanhthu
    FROM donhang dh
    JOIN chitietdonhang ctdh ON dh.ma_giohang = ctdh.ma_giohang
    JOIN sanpham sp ON ctdh.id_sanpham = sp.id_sanpham
    WHERE YEAR(dh.ngaytao) = ? AND dh.trangthai = 1
    GROUP BY MONTH(dh.ngaytao)
";
$stmt_months = $mysqli->prepare($sql_months);
if (!$stmt_months) {
    die("Lỗi truy vấn tháng: " . $mysqli->error);
}
$stmt_months->bind_param("i", $year);
$stmt_months->execute();
$result_months = $stmt_months->get_result();
while ($row = $result_months->fetch_assoc()) {
    $doanhthu_thang[$row['month']] = $row['doanhthu'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doanh Thu Năm</title>
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
            <select name="year" id="year">
                <?php foreach ($years as $y): ?>
                    <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>>
                        <?php echo $y; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Xem</button>
        </form>
    </div>

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <div class="icon"><i class="fa-solid fa-calendar"></i></div>
            <div class="label">Doanh thu năm <?php echo $year; ?></div>
            <div class="value"><?php echo number_format($doanhthu_nam, 0, ',', '.'); ?> VNĐ</div>
        </div>
    </div>

    <!-- No Data Message -->
    <?php if ($doanhthu_nam == 0): ?>
        <div class="no-data">Không có doanh thu trong năm này (hoặc không có đơn hàng đã xác nhận).</div>
    <?php endif; ?>

    <!-- Chart -->
    <div class="chart-container">
        <canvas id="doanhThuThangChart" height="100"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('doanhThuThangChart').getContext('2d');
const doanhThuThangChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Array.from({length: 12}, (_, i) => 'Tháng ' + (i + 1)),
        datasets: [{
            label: 'Doanh thu theo tháng',
            data: <?php echo json_encode(array_values($doanhthu_thang)); ?>,
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