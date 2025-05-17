<?php
    session_start();
    include("../../config/config.php");
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $ngay = date("H:i:s d-m-Y",time());
    $idkhachhang = $_SESSION['id_khach'];
    $id_sp = $_POST['id_sanpham_test'];
    $binhluan = $_POST['content'];
     
    //echo '<script type ="text/JavaScript">alert("id khach: '.$idkhachhang.'")</script>'; 
    // echo '<script type ="text/JavaScript">alert("id san pham: '.$id_sp.'")</script>';
    // echo '<script type ="text/JavaScript">alert("noi dung: '.$binhluan.'")</script>';
    // echo '<script type ="text/JavaScript">alert("ngay binh luan: '.$ngay.'")</script>';
    if(isset($_POST['thembinhluan'])){
        if(empty($binhluan)){
            //echo '<script type ="text/JavaScript">alert("Vui lòng nhập bình luận!")</script>';
            header("Location:../../index.php?quanly=sanpham&id=".$id_sp);
        }else{
            $sql_them = "INSERT INTO binhluan(id_khach, id_sanpham, noidung, ngaybinhluan) VALUES('".$idkhachhang."','".$id_sp."',
            '".$binhluan."','".$ngay."')";
            mysqli_query($mysqli,$sql_them);
            $id = $_GET['id_sanpham'];
            header("Location:../../index.php?quanly=sanpham&id=".$id_sp);
        }
        
    }
    
?>