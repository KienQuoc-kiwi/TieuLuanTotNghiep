<p>thanh toán</p>
<?php

    session_start();
    include("../../config/config.php");
    $idkhachhang = $_SESSION['id_khach'];
    $code_order = rand(0,9999);
    $insert_cart = "INSERT INTO donhang (id_khach,ma_giohang,trangthai) VALUES ('".$idkhachhang."','".$code_order."',1)";
    $cart_query = mysqli_query($mysqli,$insert_cart);
    if($cart_query){
        //thêm giỏ hàng chi tiết
        foreach($_SESSION['cart'] as $key => $value){
            $id_sanpham = $value['id'];
            $soluong = $value['soluong'];
            $insert_order_details = "INSERT INTO chitietdonhang (id_sanpham,ma_giohang,soluong) VALUES ('".$id_sanpham."','".$code_order."','".$soluong."')";
            mysqli_query($mysqli,$insert_order_details);
        }
    } 
    unset($_SESSION['cart']);
    header("Location:../../index.php?quanly=camon");
?>
