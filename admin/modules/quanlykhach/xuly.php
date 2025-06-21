<?php
    include('../../../config/config.php');

    $tenkhach = $_POST['Tenkhach'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $diachi = $_POST['Diachi'];
    $sodt = $_POST['sdt'];

    if(isset($_POST['themkhachhang'])){
        // Thêm khách hàng
        $sql_them = "INSERT INTO khachhang(ten_khach, username, password, diachi, dienthoai) VALUES('".$tenkhach."','".$username."','".$password."','".$diachi."','".$sodt."')";
        mysqli_query($mysqli, $sql_them);
        header('Location: ../../indexad.php?action=quanlykhach&query=lietke');
    } elseif(isset($_POST['suakhachhang'])){
        // Sửa khách hàng
        $sql_update = "UPDATE khachhang SET ten_khach='".$tenkhach."', username='".$username."', password='".$password."', diachi='".$diachi."', dienthoai='".$sodt."' WHERE id_khach='$_GET[Makh]'";
        mysqli_query($mysqli, $sql_update);
        header('Location: ../../indexad.php?action=quanlykhach&query=lietke');
    } else {
        // Xóa khách hàng
        $id = $_GET['Makh'];
        $sql_xoa = "DELETE FROM khachhang WHERE id_khach='".$id."'";
        mysqli_query($mysqli, $sql_xoa);
        header('Location: ../../indexad.php?action=quanlykhach&query=lietke');
    }
?>