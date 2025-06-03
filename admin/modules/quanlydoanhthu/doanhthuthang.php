<?php
$sql_thang = "
SELECT SUM(ct.soluong * sp.giasp) AS doanhthu_thang
FROM donhang dh
JOIN chitietdonhang ct ON dh.ma_giohang = ct.ma_giohang
JOIN sanpham sp ON ct.id_sanpham = sp.id_sanpham
WHERE MONTH(dh.ngaytao) = MONTH(CURDATE())
  AND YEAR(dh.ngaytao) = YEAR(CURDATE())
  AND dh.trangthai = 2
";
?>