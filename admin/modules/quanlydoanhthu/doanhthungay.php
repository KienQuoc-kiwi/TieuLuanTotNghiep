<?php
$sql_ngay = "
SELECT SUM(ct.soluong * sp.giasp) AS doanhthu_ngay
FROM donhang dh
JOIN chitietdonhang ct ON dh.ma_giohang = ct.ma_giohang
JOIN sanpham sp ON ct.id_sanpham = sp.id_sanpham
WHERE DATE(dh.ngaytao) = CURDATE()
  AND dh.trangthai = 2
";
?>