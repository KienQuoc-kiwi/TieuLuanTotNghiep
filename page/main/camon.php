<?php
if (!isset($_SESSION['id_khach'])) {
    echo "Bạn chưa đăng nhập.";
    exit;
}
?>

<div class="camon">
    <h2>🎉 Cảm ơn bạn đã đặt hàng!</h2>
    <p>Chúng tôi đã nhận được đơn hàng của bạn và sẽ xử lý trong thời gian sớm nhất.</p>
    <p>Bạn có thể xem <a href="index.php?quanly=lichsudonhang">lịch sử đơn hàng tại đây</a>.</p>
    <a href="index.php"><button>Quay về trang chủ</button></a>
</div>
