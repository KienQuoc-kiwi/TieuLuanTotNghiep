<?php
    include('../../../config/config.php');

    $tennhanvien = $_POST['Hoten'];
    $gioitinh = $_POST['Gioitinh'];
    $diachi = $_POST['Diachi'];
    $sodt = $_POST['sdt'];
    if(isset($_POST['themnhanvien'])){
        //them
        $sql_them = "INSERT INTO nhanvien(hoten_nhanvien,gioitinh,diachi,sodienthoai) VALUES('".$tennhanvien."','".$gioitinh."','".$diachi."','".$sodt."')";
        mysqli_query($mysqli,$sql_them);
        header('Location:../../indexad.php?action=quanlynhanvien&query=lietke');
    }elseif(isset($_POST['suanhanvien'])){
        //sua
        $sql_update = "UPDATE nhanvien SET hoten_nhanvien='".$tennhanvien."',gioitinh='".$gioitinh."',diachi='".$diachi."',sodienthoai='".$sodt."' WHERE id_nv='$_GET[Manv]'";
        mysqli_query($mysqli,$sql_update);
        header('Location: ../../indexad.php?action=quanlynhanvien&query=lietke');
    }else{
        $id=$_GET['Manv'];
        $sql_xoa="DELETE FROM nhanvien WHERE id_nv='".$id."'";
        mysqli_query($mysqli,$sql_xoa);
        header('Location: ../../indexad.php?action=quanlynhanvien&query=lietke');
    }
?>