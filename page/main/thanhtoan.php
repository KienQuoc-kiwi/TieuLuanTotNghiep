<p>thanh toán</p>
<?php

    session_start();
    include("../../admincp/config/config.php");
    $idkhachhang = $_SESSION['id_khachhang'];
    $code_order = rand(0,9999);
    $insert_cart = "INSERT INTO cart (id_khachhang,ma_cart,cart_status) VALUES ('".$idkhachhang."','".$code_order."',1)";
    $cart_query = mysqli_query($mysqli,$insert_cart);
    if($cart_query){
        //thêm giỏ hàng chi tiết
        foreach($_SESSION['cart'] as $key => $value){
            $id_sanpham = $value['id'];
            $soluong = $value['soluong'];
            $insert_order_details = "INSERT INTO cart_details (id_sanpham,ma_cart,soluong) VALUES ('".$id_sanpham."','".$code_order."','".$soluong."')";
            mysqli_query($mysqli,$insert_order_details);
        }
    } 
    unset($_SESSION['cart']);
    header("Location:../index.php?quanly=camon");
?>
